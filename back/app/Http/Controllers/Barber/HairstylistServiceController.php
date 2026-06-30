<?php


namespace App\Http\Controllers\Barber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HairstylistService;
use Illuminate\Support\Facades\Auth;

class HairstylistServiceController extends Controller
{
    // ثبت پست جدید توسط آرایشگر
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $service = new HairstylistService();
        $service->user_id = Auth::id();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->status = 'pending'; // وضعیت اولیه: در انتظار تایید
        $service->save();

        return response()->json(['message' => 'پست با موفقیت ثبت شد و در انتظار تایید است.'], 201);
    }

    // نمایش پست‌های تایید شده برای همه
    public function getApproved()
    {
        $services = App/Models/HairstylistService::where('status', 'approved')->get();
        return response()->json($services);
    }

    // لیست کارهای خودِ آرایشگر
    public function index()
    {
        $services = App/Models/HairstylistService::where('user_id', Auth::id())->get();
        return response()->json($services);
    }
}
