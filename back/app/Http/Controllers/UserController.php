<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // حتماً این خط را اضافه کن
use App\Models\User; // حتماً این خط را اضافه کن

class UserController extends Controller
{
    // دریافت سفارشات کاربر
    public function getOrders()
    {
        $user = Auth::user();
        if (!$user) return response()->json(['message' => 'کاربر یافت نشد'], 401);
        
        $orders = $user->orders()->latest()->get(); 
        return response()->json($orders);
    }

    // دریافت پروفایل
    public function getProfile()
    {
        return response()->json(Auth::user());
    }

    // آپدیت پروفایل
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|unique:users,mobile,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return response()->json(['message' => 'پروفایل با موفقیت بروزرسانی شد', 'user' => $user]);
    }

    // دریافت کاربرانی که منتظر تایید هستند (مخصوص پنل ادمین)
    public function getPendingUsers()
    {
        $pendingUsers = User::where('status', 0)->get();
        return response()->json($pendingUsers);
    }

    // تایید کاربر
    public function approveUser(User $user)
    {
        if ($user->status == 0) {
            $user->status = 1;
            $user->save();
            return response()->json(['message' => 'کاربر با موفقیت تایید شد']);
        }
        return response()->json(['message' => 'کاربر در وضعیت انتظار نیست'], 400);
    }

    // رد کاربر
    public function rejectUser(User $user)
    {
        if ($user->status == 0) {
            $user->status = -1; // وضعیت رد شده
            $user->save();
            return response()->json(['message' => 'کاربر رد شد']);
        }
        return response()->json(['message' => 'کاربر در وضعیت انتظار نیست'], 400);
    }

    // دریافت تاریخچه رزروهای کاربر (برای نمایش در فرانت-اند شما)
    public function getUserReservations()
    {
        // 1. دریافت آیدی کاربر لاگین شده
       $userId = Auth::id();

$reservations = DB::table('appointments')
    ->leftJoin('hairstylist_services', 'appointments.service_id', '=', 'hairstylist_services.id')
    ->where('appointments.user_id', $userId)
    ->select('appointments.*') // فقط ستون‌های جدول رزرو
    ->orderBy('appointments.id', 'desc') // اگه می‌خوای جدیدترین اول باشه
    ->get();

return response()->json($reservations);
        // 3. بازگرداندن پاسخ
    }
    // در UserController یا CourseController

public function enrollCourse(Request $request)
{
    $request->validate([
        'course_id' => 'required|integer|exists:courses,id',
    ]);

    $userId = Auth::id();

    // بررسی تکراری نبودن
    $alreadyEnrolled = DB::table('course_user')
        ->where('user_id', $userId)
        ->where('course_id', $request->course_id)
        ->exists();

    if ($alreadyEnrolled) {
        return response()->json(['message' => 'شما قبلاً در این دوره ثبت‌نام کرده‌اید'], 400);
    }

    // ذخیره
    DB::table('course_user')->insert([
        'user_id' => $userId,
        'course_id' => $request->course_id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'ثبت‌نام در دوره با موفقیت انجام شد'], 201);
}
public function userCourses()
{
    $userId = Auth::id();

    $courses = DB::table('course_user')
        ->join('courses', 'course_user.course_id', '=', 'courses.id')
        ->where('course_user.user_id', $userId)
        ->select(
            'courses.id',
            'courses.status',
            'courses.image',
            'course_user.created_at as enrolled_at'
        )
        ->orderBy('course_user.created_at', 'desc')
        ->get();

    return response()->json($courses);
}
}
