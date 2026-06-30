<?php

namespace App\Http\Controllers;

use App\Models\Newslatter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewslatterController extends Controller
{
    public function save(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        Newslatter::insert([
            'email' => $request->email,
            'created_at' => Carbon::now()
        ]);
                
        return back()->with(['newslatter' => 'ایمیل شما با موفقیت در خبرنامه ذخیره شد.']);
    }
}
