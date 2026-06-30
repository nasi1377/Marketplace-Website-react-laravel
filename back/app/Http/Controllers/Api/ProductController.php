<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // اگه ادمین بود همه رو ببینه، اگه ساپلایر بود فقط مال خودش
        if ($user->hasRole('admin')) {
            return Product::all();
        }

        return Product::where('supplier_id', $user->id)->get();
    }
}
