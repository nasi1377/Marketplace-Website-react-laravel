<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Pcategory;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\Gift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\Sms;

class ProductController extends Controller
{
    use Sms;

    // ۱. نمایش لیست محصولات ثبت شده توسط تامین‌کننده (برای ری‌اکت)
    public function index()
    {
        $supplierId = auth()->id();

        // چک کردن محصولات در جدول درخواست‌ها
        $products = DB::table('product_requests')
            ->where('supplier_id', $supplierId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($products, 200);
    }

    // ۲. ثبت محصول جدید توسط تامین‌کننده
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'price'   => 'required|numeric',
            'stock'   => 'required|integer',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'excerpt' => 'nullable|string',
            'body'    => 'nullable|string',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
        }

        $supplierId = auth()->id();

        try {
            DB::table('product_requests')->insert([
                'supplier_id' => $supplierId,
                'name'        => $validated['name'],
                'price'       => $validated['price'],
                'stock'       => $validated['stock'],
                'excerpt'     => $validated['excerpt'] ?? null,
                'body'        => $validated['body'] ?? null,
                'image'       => $path,
                'status'      => 'pending', // وضعیت اولیه
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            return response()->json([
                'status' => 'success', 
                'message' => 'محصولت ثبت شد و در انتظار تایید ادمینه',
            ], 201);

        } catch (\Exception $e) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'خطا در ثبت: ' . $e->getMessage(),
            ], 500); 
        }
    }

    // --- سایر متدهای فروشگاه (Blade Views) ---

    public function products()
    {
        $products = Product::with('variations')->orderBy('id', 'DESC')->paginate(10);
        $vip_products = Product::whereVip(1)->orderBy('id', 'DESC')->paginate(2);
        return view('products', compact('products', 'vip_products'));
    }

    public function showCategory($slug)
    {
        $category = Pcategory::where('slug', $slug)->firstOrFail();
        $products = Product::where('product_category_id', $category->id)->paginate(8);
        return view('category.index', compact('category', 'products'));
    }

    public function shopCart(Request $request)
    {
        $cart = [];
        $subTotal = 0;
        $totalWeight = 0;
        $discountAmount = 0;

        if ($request->cookie('cart')) {
            $cart = json_decode($request->cookie('cart'), true);
            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $subTotal += ($item['count']) * $product->price;
                    $totalWeight += ($item['weight'] ?? 0) * $item['count'];
                }
            }

            $discountGift = Gift::where('user_id', Auth::id())->where('title', 'کد تخفیف')->where('status', 1)->first();
            if ($discountGift && $subTotal > (int)$discountGift->value) {
                $discountAmount = (int)$discountGift->value;
            }

            $totalPrice = $subTotal - $discountAmount;
            $freeShipping = Gift::where('user_id', Auth::id())->where('title', 'ارسال رایگان')->where('status', 1)->exists();
            $send_price = $freeShipping ? 0 : ((int) setting('site.sendprice', 0)) + ($totalWeight * 3000);

            return view('shop-cart', compact('cart', 'subTotal', 'totalPrice', 'send_price', 'totalWeight', 'freeShipping', 'discountAmount'));
        }
        return redirect()->route('home')->with('error', 'سبد خرید شما خالی است.');
    }

    public function cartPayment(Request $request)
    {
        if (!$request->cookie('cart')) {
            return redirect()->back()->with('error', 'سبد خرید خالی است.');
        }

        $cart = json_decode($request->cookie('cart'), true);
        $subTotal = 0;
        $totalWeight = 0;
        $orderItemsIds = [];

        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $id_order = ProductOrder::insertGetId([
                    'author_id'  => Auth::id(),
                    'product_id' => $item['product_id'],
                    'count'      => $item['count'],
                    'weight'     => $item['weight'] ?? 0,
                    'price'      => $product->price,
                    'created_at' => Carbon::now()
                ]);

                $orderItemsIds[] = $id_order;
                $subTotal += ($item['count'] * $product->price);
                $totalWeight += (($item['weight'] ?? 0) * $item['count']);
            }

            $discountAmount = 0;
            $discountGift = Gift::where('user_id', Auth::id())->where('title', 'کد تخفیف')->where('status', 1)->first();
            if ($discountGift && $subTotal > (int)$discountGift->value) {
                $discountAmount = (int)$discountGift->value;
            }

            $freeShipping = Gift::where('user_id', Auth::id())->where('title', 'ارسال رایگان')->where('status', 1)->exists();
            $sendPrice = $freeShipping ? 0 : ((int) setting('site.sendprice', 0)) + ($totalWeight * 3000);
            $finalPayable = ($subTotal - $discountAmount) + $sendPrice;

            $order = Order::create([
                'user_id' => Auth::id(),
                'items_ids' => implode('-', $orderItemsIds),
                'total_price' => $finalPayable,
                'discount' => $discountAmount,
                'send_price' => $sendPrice,
                'status' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('payment.request', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'خطایی رخ داد: ' . $e->getMessage());
        }
    }
    public function show($id)
{
    $product = Product::findOrFail($id);

    return response()->json($product);
}
public function supplierOrders($userId)
{
    $orders = Order::with([
        'user',
        'product'
    ])
  ->whereHas('product', function ($q) use ($userId) {
    $q->where('supplier_id', $userId);
})
    ->latest()
    ->get();

    return response()->json($orders);
}
}
