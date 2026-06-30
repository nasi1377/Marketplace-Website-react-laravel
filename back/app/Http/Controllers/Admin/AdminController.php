<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\HairstylistService;
use App\Models\ProductRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
// ... (بالای کد)
use Illuminate\Support\Str; // Str رو import کن بالا
use Illuminate\Support\Facades\Auth; // Auth رو import کن بالا
// ...

class AdminController extends Controller
{
    /**
     * دریافت لیست درخواست‌های محصول
     */
    public function getPendingPosts()
    {
        try {
            // اصلاح شد: از with استفاده نمیکنیم تا مطمئن شیم اول دیتا میاد
            // اگه رابطه user رو توی مدل تعریف کردی، میتونی بعدا اضافش کنی
            $products = ProductRequest::where('status', 'pending')
                ->orderBy('id', 'desc')
                ->get();

            return response()->json($products);
        } catch (Exception $e) {
            return response()->json(['error' => 'خطا در واکشی: ' . $e->getMessage()], 500);
        }
    }
public function updateStatus(Request $request, $id)
{
    return DB::transaction(function () use ($request, $id) {
        try {
            $productReq = ProductRequest::findOrFail($id);

            $productName = $productReq->name; 
            if (empty($productName)) {
                 return response()->json(['error' => 'نام محصول یافت نشد.'], 422);
            }

            // ساخت اسلاگ
            $generatedSlug = str_replace(' ', '-', $productName) . '-' . rand(100, 999);
            
            // آماده‌سازی داده‌ها برای جدول اصلی محصولات
            $dataToCreate = [
                'supplier_id' => $productReq->supplier_id,
                'title'       => $productName,
                'price'       => (int) $productReq->price,
                'stock'       => $productReq->stock ?? 0,
                'image'       => $productReq->image,
                'status'      => 'publish', 
                'author_id'   => Auth::id() ?? $productReq->user_id ?? 1, // حتما یک آیدی معتبر باشد
                'excerpt'     => $productReq->description ?? $productName,
                'body'        => $productReq->description ?? $productName,
                'slug'        => $generatedSlug,
            ];

            // فقط یک بار ایجاد محصول
            $newProduct = Product::create($dataToCreate);
            
            // آپدیت وضعیت درخواست
            $productReq->update(['status' => 'approved']);
            
            return response()->json([
                'message' => 'Product approved and published successfully.',
                'product' => $newProduct
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    });
}

 public function pendingServices()
    {
        // معمولاً ادمین نیاز داره بدونه کدوم آرایشگر اینو فرستاده پس با user برمی‌گردونیم
        $services = HairstylistService::with('user')->where('status', 'pending')->get();
        //return response()->json($services);
    //$services = HairstylistService::all(); 
            return response()->json($services); // همیشه جیسون برگردون


    }

    // تایید یا رد کردن پست
    public function updateStatusHair(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected', // فقط این دو حالت مجاز باشه
        ]);

        $service = HairstylistService::findOrFail($id);
        $service->status = $request->status;
        $service->save();

        $message = $request->status == 'approved' ? 'پست تایید و منتشر شد.' : 'پست رد شد.';
        
        return response()->json(['message' => $message]);
    }


public function approve(Request $request, $userId)
{
    try {
        // پیدا کردن کاربر با استفاده از آیدی که از Route میاد
        $user = User::findOrFail($userId);

        if ($user->status == 1) {
            return response()->json(['message' => 'این کاربر قبلاً تأیید شده است.'], 400);
        }

        $user->status = 1; 
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'کاربر با موفقیت تأیید شد.',
            'user_id' => $user->id
        ]);

    } catch (\Exception $e) {
        return response()->json(['message' => 'خطایی رخ داد.', 'error' => $e->getMessage()], 500);
    }
}

public function getUsersgheifal()
{
    try {

        $users = User::where('status', 0)
                     ->orderBy('id', 'desc')
                     ->get();

        return response()->json($users);

    } catch (Exception $e) {
        return response()->json([
            'error' => 'خطا در دریافت لیست کاربران: ' . $e->getMessage()
        ], 500);
    }
}
public function getAllUsers()
{
    try {

        $users = User::orderBy('id', 'desc')->get();

        return response()->json($users);

    } catch (Exception $e) {
        return response()->json([
            'error' => 'خطا در دریافت لیست کاربران: ' . $e->getMessage()
        ], 500);
    }
}
public function getOrders()
{
    $orders = Order::with('user')
        ->latest()
        ->get();

    return response()->json($orders);
}
public function allBarberPosts()
{
    return HairstylistService::with('user')
        ->latest()
        ->get();
}

public function publishedProducts()
{
    return Product::with('user')
        ->where('status', 'PUBLISHED')
        ->latest()
        ->get();
}

public function publishedCourses()
{
    return Course::with('user')
        ->where('status', 'publish')
        ->latest()
        ->get();
}

}
