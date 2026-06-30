<?php
namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HairstylistService; // مهم: ایمپورت کردن مدل
use Illuminate\Support\Facades\DB;
use App\Models\ServiceSchedule;
use App\Models\Appointment;
use App\Models\CourseRequest;


class BarberController extends Controller
{
    /**
     * متدی برای ثبت سرویس جدید توسط آرایشگر.
     * این متد مستقیماً نقش کاربر رو چک نمی‌کنه، چون middleware این کار رو انجام میده.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addService(Request $request)
    {
        // $request->user() الان دیگه قابل دسترسه چون middleware قبلاً نقش رو چک کرده
        $user = $request->user();

        // اعتبارسنجی ورودی‌ها
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            // 'duration' => 'nullable|integer|min:1', // اگر لازمه
        ]);

        // ایجاد و ذخیره سرویس
        try {
            $service = new HairstylistService();
            $service->user_id = $user->id;
            $service->title = $validated['title'];
            $service->description = $validated['description'];
            $service->price = $validated['price'];
            // $service->duration = $validated['duration']; // اگر لازمه

            $service->save();

            return response()->json([
                'message' => 'سرویس با موفقیت ثبت شد.',
                'service' => $service
            ], 201); // Created

        } catch (\Exception $e) {
            // Log::error('Error saving hairstylist service: ' . $e->getMessage()); // بهتره خطا رو لاگ کنید
            return response()->json(['message' => 'خطا در ثبت سرویس. لطفاً مجدداً تلاش کنید.'], 500); // Internal Server Error
        }
    }

    // می‌تونید متدهای دیگه برای آرایشگر اینجا اضافه کنید
    // public function updateSchedule(Request $request) { ... }
    // public function getAppointments(Request $request) { ... }
    public function myServices(Request $request)
{
    return HairstylistService::where(
        'user_id',
        $request->user()->id
    )->get();
}

public function storeSchedule(Request $request)
{

    $request->validate([
        'service_id' => 'required',
        'available_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'slot_duration' => 'required'
    ]);

  ServiceSchedule::create([
    'service_id' => $request->service_id,
    'available_date' => $request->available_date,
    'start_time' => $request->start_time,
    'end_time' => $request->end_time,
    'slot_duration' => $request->slot_duration,
]);

    return response()->json([
        'message' => 'زمان رزرو ثبت شد'
    ]);
}

public function courseRequests()
{
    return CourseRequest::with([
        'user',
        'course'
    ])
    ->whereHas('course', function ($q) {
        $q->where(
            'user_id',
            auth()->id()
        );
    })
    ->latest()
    ->get();
}
public function updateCourseRequest(
    Request $request,
    $id
)
{
    $req = CourseRequest::findOrFail($id);

    $req->update([
        'status' => $request->status
    ]);

    return response()->json([
        'message' => 'بروزرسانی شد'
    ]);
}
}

