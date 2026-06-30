<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseRequest;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function reserveCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        // جلوگیری از ثبت درخواست تکراری
        $exists = Course_User::where('course_id', $request->course_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($exists) {
            return response()->json([
                'message' => 'شما قبلاً برای این دوره درخواست ثبت کرده‌اید.'
            ], 422);
        }

        $courseRequest = CourseRequest::create([
            'course_id' => $request->course_id,
            'user_id'   => Auth::id(),
            'status'    => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'درخواست ثبت‌نام با موفقیت ثبت شد.',
            'data'    => $courseRequest
        ]);
    }
    public function enroll(Course $course)
{
    $user = auth()->user();

    // بررسی کنید قبلاً ثبت‌نام نکرده باشد
    if ($user->courses()->where('course_id', $course->id)->exists()) {
        return response()->json(['message' => 'شما قبلاً در این دوره ثبت‌نام کرده‌اید'], 409);
    }

    // ذخیره در جدول course_user
    $user->courses()->attach($course->id, [
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'با موفقیت در دوره ثبت‌نام کردید']);
}

public function barberCourseRequests()
{
    $requests = \DB::table('course_user')
        ->join('courses', 'course_user.course_id', '=', 'courses.id')
        ->join('users', 'course_user.user_id', '=', 'users.id')
        ->where('courses.user_id', auth()->id())
        ->select(
            'course_user.id',
            'course_user.status',
            'course_user.created_at',
            'courses.title as course_title',
            'users.name as student_name',
            'users.mobile as student_mobile'
        )
        ->orderByDesc('course_user.id')
        ->get();

    return response()->json($requests);
}
}