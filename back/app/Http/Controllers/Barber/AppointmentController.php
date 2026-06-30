<?php

namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class AppointmentController extends Controller
{
    /**
     * دریافت زمان‌های قابل رزرو یک خدمت
     */
    public function getAvailableSlots($serviceId)
    {
        try {
            $schedules = DB::table('service_schedules')
                ->where('service_id', $serviceId)
                ->orderBy('available_date')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $schedules
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت زمان‌های رزرو',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ثبت رزرو
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id'  => 'required|exists:hairstylist_services,id',
            'schedule_id' => 'required|exists:service_schedules,id',
        ]);

        try {

            return DB::transaction(function () use ($request) {

                $userId = auth()->id();

                if (!$userId) {
                    return response()->json([
                        'success' => false,
                        'message' => 'کاربر لاگین نکرده است'
                    ], 401);
                }

                $schedule = DB::table('service_schedules')
                    ->where('id', $request->schedule_id)
                    ->lockForUpdate()
                    ->first();

                if (!$schedule) {
                    return response()->json([
                        'success' => false,
                        'message' => 'زمان انتخاب شده یافت نشد'
                    ], 404);
                }

                $exists = DB::table('appointments')
                    ->where('schedule_id', $request->schedule_id)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'این زمان قبلاً رزرو شده است'
                    ], 422);
                }

                $service = DB::table('hairstylist_services')
                    ->where('id', $request->service_id)
                    ->first();

                if (!$service) {
                    return response()->json([
                        'success' => false,
                        'message' => 'سرویس یافت نشد'
                    ], 404);
                }

$appointmentId = DB::table('appointments')->insertGetId([
    'user_id'          => $userId,
    'service_id'       => $request->service_id,
    'schedule_id'      => $request->schedule_id,
    'barber_id'        => $service->user_id,

    'appointment_date' => $schedule->available_date, // تاریخ درسته
    'appointment_time' => $schedule->start_time,    // ✅ اینجا رو از available_time به start_time تغییر بده

    'status'           => 'pending',
    'created_at'       => now(),
    'updated_at'       => now(),
]);
                return response()->json([
                    'success' => true,
                    'message' => 'رزرو با موفقیت ثبت شد',
                    'appointment_id' => $appointmentId
                ]);
            });

        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت رزرو',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function barberAppointments()
{
    $appointments = DB::table('appointments')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->join('hairstylist_services', 'appointments.service_id', '=', 'hairstylist_services.id')
        ->where('appointments.barber_id', auth()->id())
        ->select(
            'appointments.*',
            'users.name as customer_name',
            'hairstylist_services.title as service_title'
        )
        ->orderBy('appointments.created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $appointments
    ]);
}
public function approve($id)
{
    $appointment = DB::table('appointments')
        ->where('id', $id)
        ->where('barber_id', auth()->id())
        ->first();

    if (!$appointment) {
        return response()->json([
            'success' => false,
            'message' => 'رزرو پیدا نشد'
        ], 404);
    }

    DB::table('appointments')
        ->where('id', $id)
        ->update([
            'status' => 'approved',
            'updated_at' => now()
        ]);

    return response()->json([
        'success' => true,
        'message' => 'رزرو تایید شد'
    ]);
}
}