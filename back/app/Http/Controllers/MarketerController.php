<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gift;
use App\Models\City;
use App\Models\Message;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Traits\Sms;




class MarketerController extends Controller
{

    use Sms;

    private $rendered_node = 0; // تعریف صحیح ویژگی کلاس

    public function __construct()
    {
        $this->rendered_node = 0; // مقداردهی اولیه در سازنده
    }



    public function index()
    {
        // گرفتن همه‌ی کاربران و فیلتر کردن بر اساس left_user_id یا right_user_id
        $marketers = User::whereNotNull('left_user_id')
            ->orderBy('created_at', 'ASC')
            ->paginate(20);

        foreach ($marketers as $marketer) {
            $marketer->left_users_count = $marketer->leftUsersCount();
            $marketer->right_users_count = $marketer->rightUsersCount();
            $marketer->level_name = $marketer->levelsDisplay(true);
            $marketer->level_order = $marketer->levelsDisplay(false);
        }

        return view('admin.marketers.index', compact('marketers'));
    }


    public function giftsList()
    {
        $gifts = Gift::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10); // صفحه‌بندی با 10 آیتم در هر صفحه

        return view('admin.marketers.gifts', compact('gifts'));
    }

    public function deleteGift($id)
    {
        try {
            $gift = Gift::findOrFail($id);
            $gift->delete();

            return redirect()->route('admin.marketers.gifts')
                ->with('success', 'هدیه با موفقیت حذف شد');
        } catch (\Exception $e) {
            return redirect()->route('admin.marketers.gifts')
                ->with('error', 'خطا در حذف هدیه: ' . $e->getMessage());
        }
    }




    public function profile($id)
    {
        $provinces = [
            1 => 'تهران',
            2 => 'گیلان',
            3 => 'آذربایجان شرقی',
            4 => 'خوزستان',
            5 => 'فارس',
            6 => 'اصفهان',
            7 => 'خراسان رضوی',
            8 => 'قزوین',
            9 => 'سمنان',
            10 => 'قم',
            11 => 'مرکزی',
            12 => 'زنجان',
            13 => 'مازندران',
            14 => 'گلستان',
            15 => 'اردبیل',
            16 => 'آذربایجان غربی',
            17 => 'همدان',
            18 => 'کردستان',
            19 => 'کرمانشاه',
            20 => 'لرستان',
            21 => 'بوشهر',
            22 => 'کرمان',
            23 => 'هرمزگان',
            24 => 'چهارمحال و بختیاری',
            25 => 'یزد',
            26 => 'سیستان و بلوچستان',
            27 => 'ایلام',
            28 => 'کهگیلویه و بویراحمد',
            29 => 'خراسان شمالی',
            30 => 'خراسان جنوبی',
            31 => 'البرز',
        ];

        $marketer = User::whereNotNull('left_user_id')
            ->findOrFail($id);

        $role = $marketer->levelsDisplay(true);
        $cityName = $this->getCityNameById($marketer->city_id);

        $structure = $this->makenode($marketer);  // Correct variable name here

        return view('admin.marketers.profile', compact('marketer', 'role', 'provinces', 'cityName', 'structure'));  // And here
    }


    public function getCityNameById($cityId)
    {
        $city = City::where('code', $cityId)->first();
        return $city ? $city->name : 'شهر نامشخص';
    }

    private function makenode($user, $level = 0)
    {
        $this->rendered_node++;
        if ($this->rendered_node > 32) return '';

        $encrypted = Crypt::encryptString($user->id . '');
        $message = new Message();
        $unreadCount = $message->notify_msg($user->id);
        // $avatarUrl = url('storage', $user->avatar ?? 'default-avatar.png');
        $avatarUrl = $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png');

        $isCurrentUser = $user->id == Auth::id();
        $score = number_format($user->totalScore());

        ob_start(); ?>
        <li class="tree-node" data-level="<?= $level ?>">
            <div class="node-content">
                <img src="<?= $avatarUrl ?>" class="avatar" alt="<?= $user->name ?>">
                <div class="info">
                    <a href="/desktop/relationship?rel=<?= $encrypted ?>" class="user-name"><?= $user->name ?></a>
                    <div class="user-actions">
                        <a href="javascript:void(0)"
                            <?= !$isCurrentUser ? 'onclick="openUserDetail(this)" data-id="' . $user->id . '" data-name="' . $user->name . '" data-image="' . $avatarUrl . '"' : '' ?>
                            class="btn btn-success btn-sm">
                            <i class="uil <?= $unreadCount > 0 ? 'uil-chat' : 'uil-atom' ?>"></i>
                            <?= $unreadCount > 0 ? '<span class="badge badge-danger">' . $unreadCount . '</span>' : '' ?>
                            <small>امتیاز:</small><?= $score ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php if ($user->rightUser() || $user->leftUser()): ?>
                <ul class="child-nodes">
                    <?php if ($user->rightUser()): ?>
                        <?= $this->makenode($user->rightUser(), $level + 1) ?>
                    <?php endif; ?>
                    <?php if ($user->leftUser()): ?>
                        <?= $this->makenode($user->leftUser(), $level + 1) ?>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </li>

<?php return ob_get_clean();
    }

    public function sendBulkSms(Request $request)
    {
        $request->validate([
            'selected_marketers' => 'required|array',
            'selected_marketers.*' => 'exists:users,id',
            'message' => 'required|string|max:500',
        ]);

        $selectedMarketers = $request->input('selected_marketers');
        $message = $request->input('message');
        $successCount = 0;
        $failedNumbers = [];

        foreach ($selectedMarketers as $userId) {
            $marketer = User::find($userId);

            if ($marketer && $marketer->mobile) {
                try {
                    // اینجا تابع ارسال پیامک شما فراخوانی می‌شود
                    $this->sendSms($marketer->mobile, $message);
                    $successCount++;

                    // ثبت پیام در سیستم
                    Message::create([
                        'user_id' => $userId,
                        'sender_id' => Auth::id(),
                        'message' => $message,
                        'type' => 'sms',
                        'status' => 'sent'
                    ]);
                } catch (\Exception $e) {
                    $failedNumbers[] = $marketer->mobile;
                }
            } else {
                $failedNumbers[] = 'کاربر #' . $userId . ' (شماره موبایل نامعتبر)';
            }
        }

        $response = [
            'message' => "پیامک به $successCount نفر ارسال شد.",
            'success_count' => $successCount,
        ];

        if (!empty($failedNumbers)) {
            $response['failed_numbers'] = $failedNumbers;
            return response()->json($response, 207); // 207 Multi-Status
        }

        return response()->json($response, 200);
    }

    public function getGift(Request $request)
    {
        $selectedMarketers = $request->input('selected_marketers');
        $alreadyGifted = [];
        $newGifts = [];

        foreach ($selectedMarketers as $userId) {
            // $exists = Gift::where('user_id', $userId)->exists();

            $exists = Gift::where('user_id', $userId)
                ->where('title', 'ارسال رایگان')
                ->exists();


            if ($exists) {
                $alreadyGifted[] = $userId;
            } else {
                Gift::create([
                    'user_id' => $userId,
                    'title' => 'ارسال رایگان',
                    'description' => 'شما برای خرید بعدی خود ارسال رایگان دارید.',
                ]);
                $newGifts[] = $userId;
            }
        }

        if (!empty($alreadyGifted)) {
            return response()->json([
                'message' => 'برخی کاربران قبلاً هدیه دریافت کرده‌اند.',
                'already_gifted' => $alreadyGifted
            ], 400);
        }

        return response()->json([
            'message' => 'هدایا با موفقیت ثبت شدند.',
            'new_gifts' => $newGifts
        ], 200);
    }

    public function sendDiscount(Request $request)
    {
        $request->validate([
            'selected_marketers' => 'required|array',
            'discount' => 'required|numeric|min:1',
        ]);

        $discount = $request->input('discount');
        $selectedMarketers = $request->input('selected_marketers');
        $newDiscounts = [];

        foreach ($selectedMarketers as $userId) {
            Gift::create([
                'user_id' => $userId,
                'title' => 'کد تخفیف',
                'description' => 'شما یک کد تخفیف به مبلغ ' . $discount . ' تومان دریافت کرده اید.',
                'value' => $discount,
                'status' => 1, // فعال
            ]);
            $newDiscounts[] = $userId;
        }

        return response()->json([
            'message' => 'تخفیف‌ها با موفقیت ثبت شدند.',
            'new_discounts' => $newDiscounts
        ], 200);
    }
}
