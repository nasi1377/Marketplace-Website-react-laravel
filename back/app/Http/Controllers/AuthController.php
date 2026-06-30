<?php

namespace App\Http\Controllers;

// Use statements: هر کدام یک بار
use App\Models\User;
use App\Traits\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // برای Auth::check و Auth::logout
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route; // اگر در این کلاس نیاز به Route دارید
use Illuminate\Database\Eloquent\Builder; // اگر query builder پیشرفته استفاده می شود

class AuthController extends Controller
{
    // Trait Sms فقط یک بار use شود
    use Sms;

    // --- متدهای قبلی ---

    public function makeUsers(Request $request)
    {
        $inviter = intval($request->inviter);
        $parent = User::where('id', $inviter)->first();
        // اگر $parent پیدا نشود، کد زیر ممکن است خطا بدهد. بهتر است چک شود.
        if (!$parent) {
             Log::warning("makeUsers: Inviter with ID {$inviter} not found.");
             return false; // یا Exception
        }
        $users = User::where('inviter', $inviter)->skip(1)->limit(100)->get();

        foreach ($users as $user) {
            // مطمئن شوید متد setSubRelation وجود دارد و درست کار می کند
            $user->setSubRelation($parent->id, $user->id);
        }

        return true;
    }

    public function verify()
    {
        if (Auth::check()) {
            return redirect('desktop');
        }
        // اگر view وجود نداشته باشد، خطا می دهد.
        return view('auth.verify');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect('desktop');
        }
        // اگر view وجود نداشته باشد، خطا می دهد.
        return view('auth.login');
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect('desktop');
        }
        // اگر view وجود نداشته باشد، خطا می دهد.
        return view('auth.register');
    }

    /**
     * اکشن ورود کاربر
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAction(Request $request)
    {
        // validation اولیه
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
             return response()->json(['message' => 'ورودی‌ها نامعتبر هستند.', 'errors' => $validator->errors()], 422);
        }

        // تمیز کردن موبایل مانند registerAction
        $inputMobile = trim($request->mobile);
        $pureMobile = ltrim($inputMobile, '0');

        // جستجوی منعطف (چه با صفر چه بدون صفر)
        $user = User::where(function($query) use ($pureMobile) {
            $query->where('mobile', $pureMobile)
                  ->orWhere('mobile', '0' . $pureMobile);
        })->first();

        if (!$user) {
            return response()->json(['message' => 'کاربری با این شماره یافت نشد'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'رمز عبور اشتباه است'], 401);
        }

        // بررسی وضعیت فعال بودن (بخش پیامک با احتیاط)
        if ($user->status == 0) {
            try {
                $code = rand(100000, 999999); // کد 6 رقمی
                $user->update(['code' => $code]);
                // اگر پنل پیامک تنظیم نباشه این خط ممکنه خطای 500 بده
                // ارسال کد تایید
                 if ($this->sendSmsCode($user->mobile, '6onnjq1an24d8u0', $code)) { // فرض بر این است که SMS Trait کار میکند
                    return response()->json([
                        'status' => 'verify_required',
                        'mobile' => $user->mobile, // برای نمایش در فرانت
                        'message' => 'حساب شما هنوز تایید نشده است. کد تایید ارسال شد.'
                    ]);
                } else {
                     Log::warning('SMS notification failed for user ID: ' . $user->id . ' during login verification.');
                     return response()->json([
                        'status' => 'error',
                        'message' => 'خطا در ارسال کد تایید. لطفا با پشتیبانی تماس بگیرید.',
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Exception during login SMS verification for user ID ' . $user->id . ': ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'خطا در ارسال کد تایید. لطفا با پشتیبانی تماس بگیرید.'], 500);
            }
        }

        // ساخت توکن (مطمئن شو مدل User از HasApiTokens استفاده کرده)
        try {
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (\Exception $e) {
            Log::error('Error creating token for user ID ' . $user->id . ': ' . $e->getMessage());
            return response()->json(['message' => 'خطا در ایجاد توکن ورود. لطفا مجددا تلاش کنید.', 'status' => 'error'], 500);
        }


        // تعیین مسیر بر اساس نقش
        $redirectPath = '/desktop'; // پیش فرض
        switch ($user->role_id) {
            case 1: $redirectPath = '/admin'; break; // ادمین
            case 2: $redirectPath = '/desktop'; break; // کاربر عادی
            case 3: $redirectPath = '/supplier'; break; // تامین کننده
            case 4: $redirectPath = '/barber-panel'; break; // آرایشگر
            // اگر نقش دیگری تعریف شود، ممکن است خطا بدهد یا به پیش فرض برود
        }

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role_id' => $user->role_id
            ],
            'redirect_to' => $redirectPath
        ]);
    }

    /**
     * خروج از حساب کاربری
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        // بعد از خروج، آنی که دارد توکن یا سشن را پاک می کند
        // این یک ریدایرکت به صفحه لاگین است. اگر API باشد، باید response json باشد
        // return response()->json(['message' => 'با موفقیت خارج شدید.']);
        return redirect("login")->with(['auth_success' => 'با موفقیت از سیستم خارج شدید.']);
    }

    // --- متد Register Action ---

    /**
     * ثبت نام کاربر جدید با منطق تایید بر اساس نقش
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerAction(Request $request)
    {
        // 1. تمیز کردن شماره موبایل
        $mobile = null;
        if ($request->has('mobile')) {
            // تمیز کردن قبل از $request->merge
            $mobile = ltrim(trim($request->mobile), '0');
            // اگر موبایل تمیز شده معتبر است، آن را در request اضافه کن
            if (!empty($mobile)) {
                $request->merge(['mobile' => $mobile]);
            } else {
                // اگر بعد از تمیز کردن خالی شد (مثلا فقط صفر بوده)
                return response()->json(['status' => 'error', 'message' => 'فرمت شماره موبایل نامعتبر است.'], 422);
            }
        }

        // 2. ولیدیشن دقیق ورودی‌ها
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'family'    => 'required|string|max:255',
            // 10 رقم، بدون صفر و از سمت بک‌اِند تمیز شده
            'mobile'    => 'required|digits:10|unique:users,mobile',
            'password'  => 'required|min:6',
            'role_id'   => 'required|in:2,3,4', // نقش‌های مجاز
            // قانون document:
            // - nullable: چون برای نقش 2 لازم نیست
            // - image, mimes, max: برای انواع تصویر و حجم
            // - تابع سفارشی: برای اجباری کردن آن برای نقش 3 و 4
            'document'  => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:3072', // 3MB
                function ($attribute, $value, $fail) use ($request) {
                    $roleId = $request->input('role_id'); // نقش انتخاب شده

                    // اگر نقش کاربر عادی (2) است و فایلی آپلود شده، خطا بده
                    if ($roleId == 2 && $request->hasFile('document')) {
                        $fail('آپلود مدرک برای کاربر عادی مجاز نیست.');
                    }
                    // اگر نقش تامین کننده (3) یا آرایشگر (4) است و فایلی آپلود نشده، خطا بده
                    elseif (in_array($roleId, [3, 4]) && !$request->hasFile('document')) {
                        $fail('آپلود مدرک یا جواز کسب برای تأمین کننده و آرایشگر الزامی است.');
                    }
                }
            ],
        ],
        // پیام های خطای سفارشی
        [
            'name.required' => 'فیلد نام الزامی است.',
            'family.required' => 'فیلد نام خانوادگی الزامی است.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.digits' => 'شماره موبایل باید 10 رقم و بدون صفر ابتدایی باشد.',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت‌نام شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min'  => 'رمز عبور باید حداقل 6 کاراکتر باشد.',
            'role_id.required' => 'انتخاب نقش کاربری الزامی است.',
            'role_id.in' => 'نقش کاربری انتخابی معتبر نیست.',
        ]);

        // اگر ولیدیشن با خطا مواجه شد، همان خطاها را برگردان
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'خطا در ورودی‌ها.',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // 3. آپلود فایل در صورت لزوم (برای نقش 3 و 4)
        $documentPath = null;
        if (in_array($request->role_id, [3, 4]) && $request->hasFile('document')) {
            try {
                $file = $request->file('document');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('uploads/documents');

                // اگر پوشه وجود نداشت، ایجاد کن
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0775, true); // 0775 permissions allow owner and group to read/write/execute, others to read/execute
                }

                $file->move($uploadPath, $filename);
                $documentPath = 'uploads/documents/' . $filename;
            } catch (\Exception $e) {
                 Log::error('Error uploading document for registration: ' . $e->getMessage(), ['exception' => $e]);
                 return response()->json([
                    'status' => 'error',
                    'message' => 'خطا در آپلود فایل مدرک. لطفاً مجدداً تلاش کنید.',
                ], 500);
            }
        }

        // 4. تعیین وضعیت اولیه کاربر بر اساس نقش
        $userStatus = 0; // پیش فرض: غیرفعال (نیاز به تایید مدیر)
        if ($request->role_id == 2) { // کاربر عادی
            $userStatus = 1; // فعال
        }

        // 5. ایجاد کاربر در دیتابیس
        try {
            // اطمینان از وجود فیلدهای مورد نیاز در دیتابیس و مدل User
            $user = User::create([
                'name'      => $request->name,
                'family'    => $request->family,
                'mobile'    => $mobile, // شماره تمیز شده
                'password'  => Hash::make($request->password), // رمز عبور رمزنگاری شده
                'role_id'   => $request->role_id,
                'status'    => $userStatus, // وضعیت بر اساس نقش تعیین می شود
                'code'      => rand(100000, 999999), // کد تایید 6 رقمی
                'document'  => $documentPath, // مسیر فایل مدرک (ممکن است null باشد)
            ]);

            // 6. ارسال پیامک تایید (فعال کردن در صورت نیاز)
            /*
            try {
                // اگر sendSmsCode کار می کند و پیامک لازم است، این بخش را فعال کنید
                // $this->sendSmsCode($user->mobile, '6onnjq1an24d8u0', $user->code);
            } catch (\Exception $e) {
                Log::error('SMS sending failed for user ID ' . $user->id . ' during registration. Error: ' . $e->getMessage());
            }
            */

            // 7. پاسخ موفقیت آمیز
            $successMessage = 'ثبت‌نام شما با موفقیت انجام شد.';
            if ($userStatus == 0) { // اگر نیاز به تایید بود (status = 0)
                $successMessage .= ' لطفا منتظر تایید مدیر سیستم باشید.';
            } else { // اگر فعال بود (status = 1)
                $successMessage .= ' می‌توانید وارد حساب کاربری خود شوید.';
            }

            return response()->json([
                'status' => 'success',
                'message' => $successMessage,
                'user_id' => $user->id
            ], 201); // 201 Created

        } catch (\Exception $e) {
            // خطای احتمالی در دیتابیس یا جای دیگر
            // اگر فایلی آپلود شده بود و مشکلی در ذخیره کاربر رخ داد، فایل را پاک کن
            if ($documentPath && file_exists(public_path($documentPath))) {
                 try {
                    unlink(public_path($documentPath));
                 } catch (\Exception $unlinkException) {
                    Log::error('Failed to delete uploaded document after registration error: ' . $unlinkException->getMessage());
                 }
            }

            // لاگ کردن خطای کامل برای دیباگ
            Log::error('Error during user registration process.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all() // داده های ارسالی را هم در لاگ ذخیره کن
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'خطا در ذخیره‌سازی اطلاعات. لطفاً مجدداً تلاش کنید.',
            ], 500); // 500 Internal Server Error
        }
    }
}
