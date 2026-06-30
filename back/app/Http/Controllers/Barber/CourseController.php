<?php

namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * ثبت دوره توسط آرایشگر
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('courses', 'public');
        }

        $course = Course::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'دوره برای تایید ادمین ارسال شد',
            'data' => $course
        ], 201);
    }

    /**
     * لیست دوره‌های منتشر شده
     */
    public function index()
    {
        $courses = Course::where('status', 'publish')
            ->latest()
            ->get();

        return response()->json($courses);
    }

    /**
     * لیست دوره‌های در انتظار تایید
     */
 public function pendingCourses()
{
    return Course::where('status', 'pending')
        ->latest()
        ->get();
}

public function approveCourse($id)
{
    $course = Course::findOrFail($id);

    $course->update([
        'status' => 'publish'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'دوره با موفقیت تایید شد'
    ]);
}
public function show($id)
{
    $course = Course::with('user')->findOrFail($id);

    return response()->json($course);
}

public function rejectCourse($id)
{
    $course = Course::findOrFail($id);

    $course->update([
        'status' => 'rejected'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'دوره رد شد'
    ]);
}

}