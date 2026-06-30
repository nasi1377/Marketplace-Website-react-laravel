<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\ProductReturned;

use App\Models\User;
use App\Models\Message;
use App\Models\RequestM;
use App\Models\Transaction;
use App\Models\ReCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use PayPing\PayPingException;
use Illuminate\Support\Facades\DB;
use App\Models\Order;


class DesktopController extends Controller
{

    private  $rendered_node = 0;


    public function index()
    {
        return view('desktop.index');
    }

    public function profile()
    {
        $orders = ProductOrder::all(); 

    return view('desktop.profile', compact('orders'));
    }

// برای مرجوعی و هدایا هم متدهای مربوطه رو بساز:


    public function invoice($order_id, Request $request)
    {
        $order =   ProductOrder::where('id', $order_id)->first();
        $product = Product::whereId($order->product_id)->first();
        return view('desktop.invoice', compact('order', 'product'));
    }


   

    public function upload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $png_url = "avt-" . time() . "_" . rand(1, 100) . ".png";
        $path = base_path('../html/storage/users/');

        // if (!file_exists($path)) {
        //     if( mkdir($path, 0755, true))
        //     {
        //         umask(0);
        //         chmod($path, 0755);
        //     }
        // }

        //$path = $path . $png_url;

        //Image::make(file_get_contents($request->file))->resize(300, 200)->save($path);
        $request->file->move($path, $png_url);

        return response()->json([
            'url' => 'users/' . $png_url,
            'status' => 'success'
        ], 200);
    }


    // فایل app/Http/Controllers/DesktopController.php



    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'family' => 'required',
            'mobile' => 'required|iran_mobile',
            // 'nation_code' => 'melli_code',
            // 'cart' => 'required',
            // 'zipcode' => 'required',
            // 'address' => 'required', 

        ]);

        $user = Auth::user();
        if ($user->email != $request->email) {
            // $request->validate(['email' => 'unique:users']);
        }

        if ($user->mobile != $request->mobile) {
            $request->validate(['mobile' => 'unique:users']);
        }

        $is_nation_code = User::where('id', '!=', Auth::id())
            ->where('settings', 'LIKE', "%\"nation_code\":\"{$request->nation_code}\"%")
            ->exists();

        if ($is_nation_code) {
            return back()->withErrors(['nation_code' => 'کد ملی قبلا در سیستم ثبت شده است.']);
        }

        $settings = $user->settings;
        $settings['nation_code'] = $request->nation_code;
        $settings['phone'] = $request->phone;
        $settings['name'] = $request->name;
        $settings['family'] = $request->family;
        $settings['zipcode'] = $request->zipcode;
        $settings['address'] = $request->address;
        $settings['sheba'] = $request->sheba;
        $settings['cart'] = $request->cart;
        $settings['access'] = $request->access;


        User::whereId($user->id)->update([
            'name' => $request->name . ' ' . $request->family,
            'email' => $request->has('email') && !empty($request->email) ? $request->email : NULL,
            'mobile' => $request->mobile,
            'settings' => $settings,
            'avatar' => $request->avatar,
            'city_id' => $request->city_id,
            'prov_id' => $request->prov_id,
            'address' => $request->full_address . " - " . $request->address . " / تلفن:" . $request->phone . "  کدپستی:" . $request->zipcode,
        ]);

        // بازگشت پیام موفقیت
        return back()->with(['message_success' => 'اطلاعات پروفایل با موفقیت بروز رسانی شد.']);
    }





    public function orders()
    {
        $orders = ProductOrder::whereAuthorId(Auth::id())->orderBy('id', 'DESC')->get();
        return view('desktop.orders', compact('orders'));
    }




    public function ordersReferred(Request $request)
    {
        $request->validate([
            'order' => 'required|numeric',
            'message' => 'required'
        ]);

        // دریافت اطلاعات سفارش
        $order = ProductOrder::find($request->order);

        // dd($order);

        if (!$order) {
            return back()->with('message_error', 'سفارش موردنظر یافت نشد.');
        }

        // بروزرسانی وضعیت سفارش
        $order->update([
            'status' => 'REFERRED',
            'message_referred' => $request->message
        ]);


        ProductReturned::create([
            'product_order_id' => $order->id,
            'author_id' => $order->author_id,
            'product_id' => $order->product_id,
            'weight' => $order->weight,
            'size' => $variation->size,  // مقدار رو از متغیر variation بگیر
            'color'=> $variation->color, // مقدار رو از متغیر variation بگیر
            'mobile' => Auth::user()->mobile, // دریافت شماره موبایل کاربر لاگین‌شده
            'return_message' => $request->message
        ]);


        return back()->with([
            'message_success' => 'درخواست شما ثبت شد!',
            'message_error' => 'درخواست ارجاع محصول با کد پیگیری "' . ($order->id + 1000) . '" تأیید شد.
            لطفاً محصول را طی یک هفته آتی به آدرس:پستی اصفهان بهارستان مجمتع افتخار 
            📞 شماره تماس:  - 09167479884
            پس از دریافت محصول، تمام هزینه به حساب شما منظور خواهد شد.'
        ]);
    }


    public function buyMajor()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('desktop.buy-major', compact('products'));
    }

    public function buyMajorSave(Request $request)
    {
        $request->validate([
            'product' => 'required|numeric',
            'weight' => 'required|numeric',
            'size' => 'required|numeric',
            'color' => 'required|numeric',
            'mobile' => 'required|iran_mobile',
            'phone' => 'required',
            'phone' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
        ]);

        $user = Auth::user();

        if ($user->mobile != $request->mobile) {
            $request->validate(['mobile' => 'unique:users']);
        }

        $settings = $user->settings;
        $settings['phone'] = $request->phone;
        $settings['zipcode'] = $request->zipcode;
        $settings['address'] = $request->address;


        User::whereId($user->id)->update([
            'mobile' => $request->mobile,
            'settings' => $settings
        ]);

        $product = Product::whereId($request->product)->first();

        $order_id =  ProductOrder::insertGetId([
            'author_id' => Auth::id(),
            'product_id' => $request->product,
            'price' => $product->price, // * $request->weight,
            'weight' => $request->weight,
            'size' => $request->size,
            'color' => $request->color,
            'type' => 'MAJOR',
            'status' => 'PENDING',
            'created_at' => Carbon::now()
        ]);


        //  $order =   ProductOrder::where('id', $order_id)->first(); 



        //  $totalPrice =   $order->weight * $order->price ;
        //  $orders_ids = ''.$order->id;
        //
        // return $this->payment($totalPrice,$orders_ids);


        return redirect(route('desktop.invoice', ['order_id' => $order_id]));

        // return back()->with(['message_success' => 'سفارش عمده شما با موفقیت ثبت شد.']);
    }

    public function GotoPayment($order_id, Request $request)
    {
        $order =   ProductOrder::where('id', $order_id)->first();

        $totalPrice =   ( $order->count) * $order->price;
        $orders_ids = '' . $order->id;


        // $send_price = (int) setting('site.sendprice');

        //  $send_price = ((int) setting('site.sendprice')) * (  $order->weight * $order->count);

        $send_price = ((int) setting('site.sendprice')) +  ($order->weight * $order->count) * 3000;

        $send_price =  $send_price / (($order->type == 'SINGLE') ? 1 : 1);
        $totalPrice +=   $send_price;

        // dd($totalPrice);


        return $this->payment($totalPrice, $orders_ids);
    }


    private function payment($totalPrice, $orders_ids)
    {

        $token = "32C75435A1792C0B3B570EE32A99E5CEC49EF1C43B7FAA36217D6EF588FD6855-1";
        $args = [
            "amount" => $totalPrice,
            "payerIdentity" => strval(Auth::id()),
            "payerName" => Auth::user()->name,
            "description" => "توضیحات",
            "returnUrl" => route('cart.callback'),
            "clientRefId" => $orders_ids
        ];

        $payment = new \PayPing\Payment($token);



        try {
            $payment->pay($args);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        return redirect($payment->getPayUrl());
    }

    public function recruitment()
    {
        return view('desktop.recruitment');
    }

    public function return()
    {
        $orders = ProductOrder::whereAuthorId(Auth::id())->orderBy('id', 'DESC')->get();

        return view('desktop.return', compact('orders'));
    }

    public function recruitmentUpdate(Request $request)
    {
        if ($request->right_user_code) {
            $request->validate(['right_user_code' => 'numeric']);
            $right_user = Auth::user()->getUserByInviteCode($request->right_user_code);
            if (!$right_user) {
                return back()->withErrors(['right_user_code' => 'کدمعرفی نا معتبر است.']);
            }
            $user_id = Auth::user()->getIdByInviteCode($request->right_user_code);
            $checkUsed = User::whereRightUserId($user_id)->orWhere('right_user_id', $user_id)->first();
            if ($checkUsed) {
                if ($checkUsed->id != Auth::id()) {
                    return back()->withErrors(['right_user_code' => 'کدمعرفی قبلا استفاده شده است.']);
                } else {
                    if ($checkUsed->left_user_id == $user_id) {
                        return back()->withErrors(['right_user_code' => 'کدمعرفی در بازوی چپ تعریف شده است.']);
                    }
                }
            }
            if ($request->right_user_code == Auth::user()->getInviteCode()) {
                return back()->withErrors(['right_user_code' => 'کدمعرفی خودتان است!']);
            }

            User::whereId(Auth::id())->update([
                'right_user_id' => $user_id
            ]);
        }

        if ($request->left_user_code) {
            $request->validate(['left_user_code' => 'numeric']);
            $left_user = Auth::user()->getUserByInviteCode($request->left_user_code);
            if (!$left_user) {
                return back()->withErrors(['left_user_code' => 'کدمعرفی نا معتبر است.']);
            }
            $user_id = Auth::user()->getIdByInviteCode($request->left_user_code);
            $checkUsed = User::whereRightUserId($user_id)->orWhere('left_user_id', $user_id)->first();
            if ($checkUsed) {
                if ($checkUsed->id != Auth::id()) {
                    return back()->withErrors(['left_user_code' => 'کدمعرفی قبلا استفاده شده است.']);
                } else {
                    if ($checkUsed->right_user_id == $user_id) {
                        return back()->withErrors(['left_user_code' => 'کدمعرفی در بازوی راست تعریف شده است.']);
                    }
                }
            }
            if ($request->left_user_code == Auth::user()->getInviteCode()) {
                return back()->withErrors(['left_user_code' => 'کدمعرفی خودتان است!']);
            }

            User::whereId(Auth::id())->update([
                'left_user_id' => $user_id
            ]);
        }

        return back()->with(['message_success' => 'اطلاعات زیرمجموعه با موفقیت بروز رسانی شد.']);
    }



    // public function wallet()
    // {
    //     $user = Auth::user();

    //     // دریافت محصولات برنج (دسته‌بندی 5)
    //     $riceProducts = Product::where('status', 1) // محصولات فعال
    //         ->get();

    //     // محاسبه مجموع امتیازات کاربر
    //     $totalScore = $user->transactions()->sum('value');
    //     $totalRice = $user->transactions()->sum('rice_amount');
    //     $gifts = $user->gifts;

    //     // $totalScore = Transaction::where('user_id', $user->id)->sum('value');

    //     return view('desktop.wallet', [
    //         'transactions' => $user->transactions,
    //         'riceProducts' => $riceProducts,
    //         'totalScore' => $totalScore,
    //         'totalRice' => $totalRice,
    //         'gifts' => $gifts
    //     ]);
    // }



    public function wallet()
    {
        $user = Auth::user();

        // دریافت محصولات برنج
        $riceProducts = Product::where('status', 1)->get();

        // محاسبه مجموع امتیازات کاربر
        $totalScore = $user->transactions()->sum('value');
        $totalRice = $user->transactions()->sum('rice_amount');
        $gifts = $user->gifts;

        // دریافت تراکنش‌ها با اطلاعات محصول مرتبط
        $transactions = $user->transactions()->with('riceProduct')->latest()->get();

        return view('desktop.wallet', [
            'transactions' => $transactions, // تراکنش‌ها با رابطه محصول
            'riceProducts' => $riceProducts,
            'totalScore' => $totalScore,
            'totalRice' => $totalRice,
            'gifts' => $gifts
        ]);
    }


    public function sendRequest(Request $request)
    {

        $request->validate([
            'credit' => 'required|numeric'
        ]);

        if ($request->credit < 500000) {
            return back()->with(['message_error' => 'مبلغ مورد نظر کمتر از ' . number_format(500000) . ' ریال باشد']);
        }

        $user = User::where('id', Auth::id())->first();

        if ($request->credit >  $user->credit) {
            return back()->with(['message_error' => 'مبلغ مورد نظر نباید بیشتر از اعتبار  باشد']);
        }



        $user->decrement('credit', $request->credit);



        RequestM::insertGetId([
            'user_id' =>  $user->id,
            'value' => $request->credit,
            'status' => 0,
            'created_at' => Carbon::now(),
            'created_at' => 1,
        ]);



        return redirect()->route('desktop.wallet')->with(['message_success' => 'درخواست واریز شما ثبت شد']);
    }



    // public function sendRequestRice(Request $request)
    // {
    //     $request->validate([
    //         'rice_amount' => 'required|numeric|min:2'
    //     ]);

    //     $user = Auth::user();
    //     $requestedAmount = $request->rice_amount;

    //     // تراکنش‌های برنج کاربر به ترتیب تاریخ (قدیمی‌ترین اول)
    //     $riceTransactions = Transaction::where('user_id', $user->id)
    //         ->where('type', 2)
    //         ->whereNotNull('rice_amount')
    //         ->orderBy('created_at')
    //         ->get();

    //     if ($riceTransactions->isEmpty()) {
    //         return back()->with(['message_error' => 'شما هیچ تراکنش برنجی برای تبدیل ندارید!']);
    //     }

    //     $totalRice = $riceTransactions->sum('rice_amount');

    //     if ($requestedAmount > $totalRice) {
    //         return back()->with(['message_error' => 'مقدار درخواستی بیشتر از موجودی برنج شماست!']);
    //     }

    //     // ثبت درخواست
    //     RequestM::create([
    //         'user_id' => $user->id,
    //         'rice_amount' => $requestedAmount,
    //         'value' => 0,
    //         'status' => 0,
    //         'type' => 2,
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);

    //     // کاهش یا حذف تراکنش‌های برنج
    //     $remainingAmount = $requestedAmount;
    //     foreach ($riceTransactions as $transaction) {
    //         if ($remainingAmount <= 0) break;

    //         if ($transaction->rice_amount <= $remainingAmount) {
    //             // حذف کامل تراکنش اگر مقدار آن کمتر یا مساوی مقدار درخواستی باشد
    //             $remainingAmount -= $transaction->rice_amount;
    //             $transaction->delete();
    //         } else {
    //             // کاهش مقدار تراکنش اگر بیشتر از مقدار درخواستی باشد
    //             $transaction->decrement('rice_amount', $remainingAmount);
    //             $remainingAmount = 0;
    //         }
    //     }

    //     return redirect()->route('desktop.wallet')->with([
    //         'message_success' => 'درخواست تبدیل ' . $requestedAmount . ' کیلوگرم برنج شما ثبت شد و از موجودی کسر شد'
    //     ]);
    // }



    public function sendRequestRice(Request $request)
    {
        $user = Auth::user();

        // همه تراکنش‌های برنج کاربر
        $riceTransactions = Transaction::where('user_id', $user->id)
            ->where('type', 2)
            ->whereNotNull('rice_amount')
            ->orderBy('created_at')
            ->get();

        if ($riceTransactions->isEmpty()) {
            return back()->with(['message_error' => 'شما هیچ تراکنش برنجی برای تبدیل ندارید!']);
        }

        $totalRice = $riceTransactions->sum('rice_amount');

        // برای هر تراکنش یک درخواست ثبت می‌کنیم
        foreach ($riceTransactions as $transaction) {
            RequestM::create([
                'user_id' => $user->id,
                'value' => 0,
                'type' => 2,
                'id_rice' => $transaction->id_rice,
                'status' => 0,
                'totalRice' => $totalRice,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // حذف همه تراکنش‌های برنج
        Transaction::where('user_id', $user->id)
            ->where('type', 2)
            ->whereNotNull('rice_amount')
            ->delete();

        return redirect()->route('desktop.wallet')->with([
            'message_success' => 'درخواست تبدیل ' . $totalRice . ' کیلوگرم برنج شما ثبت شد و از موجودی کسر شد'
        ]);
    }




    public function chargeCredit(Request $request)
    {
        $request->validate([
            'credit' => 'required|numeric'
        ]);

        if ($request->credit < (int) setting('gateway.min_price')) {
            return back()->with(['message_error' => 'مبلغ مورد نظر کمتر از ' . number_format(setting('gateway.min_price')) . ' ریال باشد']);
        }
        ////////////////////////////////////////////////////////////////////////

        $tran_id =  ReCharge::insertGetId([
            'user_id' => Auth::id(),
            'value' => $request->credit,

            'created_at' => Carbon::now()
        ]);

        //$token = "32C75435A1792C0B3B570EE32A99E5CEC49EF1C43B7FAA36217D6EF588FD6855-1";
        $args = [
            "amount" => $request->credit / 10,
            "payerIdentity" => strval(Auth::id()),
            "payerName" => Auth::user()->name,
            "description" => "شارژ حساب",
            "returnUrl" => route('desktop.wallet.callback'),
            "clientRefId" => $tran_id
        ];

        $payment = new \PayPing\Payment($token);



        try {
            $payment->pay($args);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        return redirect($payment->getPayUrl());

        ////////////////////////////////////////////////////////////////////////////////////

    }

    public function CallBack(Request $request)
    {

        $token = "32C75435A1792C0B3B570EE32A99E5CEC49EF1C43B7FAA36217D6EF588FD6855-1";

        $payment = new \PayPing\Payment($token);


        $id =  $_GET['clientrefid'];
        $amount = 0;


        $tran = ReCharge::find(intval($id));

        $amount = $tran->getAttribute("value");


        try {

            if ($payment->verify($_GET['refid'], $amount / 10)) {


                User::whereId(Auth::id())->increment('credit', $amount);

                return redirect()->route('desktop.wallet')->with(['message_success' => 'مبلغ ' . number_format($amount) . ' ریال توسط درگاه مجازی به حساب شما واریز شد.']);
            }
        } catch (PayPingException $e) {

            return redirect()->route('desktop.wallet')->with(['message_error' => 'خطایی در درگاه رخ داده، در صورت کسر از حساب طی 72 ساعت مبلغ عودت داده میشود']);
        } catch (Exception $e) {
            return redirect()->route('desktop.wallet')->with(['message_error' => $e->getMessage()]);
        }
    }



    public function ScoreToCredit()
    {
        $user = User::whereId(Auth::id())->first();

        $result =  $user->convertToCredit();

        $reward_price = $result["credit"];
        $total_balanced = $result["total_balanced"];

        User::whereId(Auth::id())->increment('credit', $reward_price * 10000);


        if ($reward_price != 0 && $total_balanced != 0) {
            Transaction::insertGetId([
                'user_id' => Auth::id(),
                'left_score' => intdiv($total_balanced, 2),
                'right_score' => intdiv($total_balanced, 2),
                'total_score' => $total_balanced,
                'value' => $reward_price * 10000,
                'type' => 1,
                'created_at' => Carbon::now(),
            ]);
        }



        return back()->with(['message_success' => 'کل امیتازات شما به ' . number_format($reward_price * 10000) . ' ریال موجودی تبدیل شد.']);
    }





    public function scoreToRice(Request $request)
    {
        $request->validate([
            'rice_product' => 'required|exists:products,id'
        ]);

        $user = Auth::user();
        $riceProduct = Product::findOrFail($request->rice_product);

        // تراکنش‌های اعتباری کاربر
        $creditTransactions = Transaction::where('user_id', $user->id)
            ->where('type', 1)
            ->orderBy('id')
            ->get();

        $totalCredit = $creditTransactions->sum('value');

        if ($totalCredit <= 0) {
            return back()->with(['message_error' => 'اعتبار کافی برای خرید برنج وجود ندارد']);
        }

        // قیمت هر کیلو برنج (به ریال)
        $pricePerKg = $riceProduct->price * 10;

        if ($pricePerKg <= 0) {
            return back()->with(['message_error' => 'قیمت محصول نامعتبر است']);
        }

        // حداکثر مقدار برنج قابل خرید با کل اعتبار
        $maxRiceAmount = $totalCredit / $pricePerKg;


        // اعتبارسنجی حداقل 1 کیلوگرم
        if ($maxRiceAmount < 2) {
            return back()->with(['message_error' => 'موجودی شما به اندازه خرید یک کیلو برنج نیست!']);
        }

        // در اینجا می‌توانید از کاربر مقدار مورد نظرش را بپرسید یا کل مقدار را استفاده کنید
        $riceAmount = $maxRiceAmount; // یا مقدار دلخواه کاربر (با اعتبارسنجی)
        $usedCredit = $riceAmount * $pricePerKg;

        // ثبت تراکنش خرید برنج
        Transaction::create([
            'user_id' => $user->id,
            'value' => 0,
            'rice_amount' => (int) $riceAmount,
            'id_rice' => (int) $riceProduct->id,
            'type' => 2,
            'created_at' => now(),
            'updated_at' => now(),
            'left_score' => 0,
            'right_score' => 0,
            'total_score' => 0
        ]);

        // کاهش موجودی انبار
        $riceProduct->decrement('stock', $riceAmount);

        // حذف فقط تراکنش‌های استفاده شده (به میزان مبلغ خرج شده)
        $remainingCredit = $usedCredit;
        foreach ($creditTransactions as $transaction) {
            if ($remainingCredit <= 0) break;

            if ($transaction->value <= $remainingCredit) {
                // کل این تراکنش استفاده شده
                $remainingCredit -= $transaction->value;
                $transaction->delete();
            } else {
                // فقط بخشی از این تراکنش استفاده شده
                $transaction->value -= $remainingCredit;
                $transaction->save();
                $remainingCredit = 0;
            }
        }

        return back()->with([
            'message_success' => sprintf(
                '%.2f کیلوگرم برنج %s با موفقیت خریداری شد. مبلغ %s ریال کسر شد.',
                $riceAmount,
                $riceProduct->title,
                number_format($usedCredit)
            )
        ]);
    }




    private function makenode($user)
    {

        $this->rendered_node++;

        if ($this->rendered_node == 33) return '';

        $stracture = '';
        $stracture .= '<li>';

        $encrypted = Crypt::encryptString($user->id . '');

        $message = new Message();

        $link = '/desktop/relationship?rel=' . $encrypted;

        $c = $message->notify_msg($user->id);

        $stracture .= '<code ' . (($c > 0) ? ' class=" blink " ' : '') . '  > 
   
        <div class="text-center">
                            <img src="' . url('storage', $user->avatar) . '" class="avatar avatar-medium shadow-lg rounded-pill" alt="' . $user->name . '">
                            <div class="content mt-3">
                                <a href="' . $link . '" class="h5 text-dark">' . $user->name . '</a>
                                <div style="margin-top: 10px">';

        if ($user->id == Auth::user()->id)
            $stracture .= '<a href="javascript:void(0)"     class="btn btn-success">';
        else
            $stracture .= '<a href="javascript:void(0)" onclick="openUserDetail(this)"  data-id="' . $user->id . '" data-name="' . $user->name . '" data-image="' . url('storage', $user->avatar) . '"   class="btn btn-success">';


        if ($c == 0)
            $stracture .= '<i class="uil uil-atom"></i>';
        else
            $stracture .= '<i class="uil uil-chat"></i>';

        if ($c > 0)
            $stracture .= ' <span class="badge badge-danger">' . $c . '</span>';



        $stracture .= ' <small> امتیاز :</small>' . number_format($user->totalScore()) . ' </a>
                                </div>
                            </div>
                        </div>
        
        </code>';
        $stracture .= '<ul>';

        if ($user->rightUser()) {
            $stracture .= $this->makenode($user->rightUser());
        }

        if ($user->leftUser()) {
            $stracture .= $this->makenode($user->leftUser());
        }

        $stracture .= '</ul>';

        $stracture .= '</li>';


        return $stracture;
    }

    public function relationship(Request $request)
    {
        $user_id = null;
        $back = false;

        if ($request->has('rel')) {
            $user_id =  Crypt::decryptString($request->get('rel'));
        }


        if ($user_id == null) {
            $user = User::whereId(Auth::id())->first();
        } else {
            $user = User::whereId(intval($user_id))->first();
            $back = true;
        }

        $c_level = 0;
        $end_level = 4;

        $stracture = $this->makenode($user);

        $topUser =  $user->getMyRoot();

        $parents = array();
        $_parents =  $user->getAllParents();

        foreach ($_parents as $parent) {
            array_push($parents,  User::whereId($parent["id"])->first());
        }

        $message = new Message();


        return view('desktop.relationship', compact(['topUser', 'user', 'stracture', 'back', 'parents', 'message']));
    }



    public function giftBox()
    {
        return view('desktop.gift-box');
    }

    public function inactiveUsers()
    {
        $user_id = Auth::id();
        $loop = true;
        $users_ids = [];
        while ($loop) {
            $user = User::whereId($user_id)->first();
            if (!$user->right_user_id || !$user->left_user_id) {
                if (Auth::id() != $user_id) {
                    array_push($users_ids, $user_id);
                }
            }
            if (!$user->right_user_id && !$user->left_user_id) {
                $loop = false;
                break;
            }
            $user_id = $user->right_user_id;
        }
        $users = User::whereIn('id', $users_ids)->get();

        return view('desktop.inactive-users', compact('users'));
    }


    public  function sendMsg(Request $request)
    {
        $msg = new  Message();

        return $msg->send_msg($request->user_id, $request->msg);
    }

    public function LoadMsgByUser(Request $request)
    {
        $msg = new  Message();

        return $msg->read_msg($request->user_id);
    }

    public function ReadMsgByUser(Request $request)
    {
        $msg = new  Message();

        return $msg->read_only_msg($request->user_id);
    }
}
