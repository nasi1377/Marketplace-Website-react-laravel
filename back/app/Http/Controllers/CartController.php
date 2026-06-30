<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $userId = Auth::id();

        $productId = $request->product_id;

        $item = DB::table('cart_items')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($item) {

            DB::table('cart_items')
                ->where('id', $item->id)
                ->update([
                    'quantity' => $item->quantity + 1,
                    'updated_at' => now()
                ]);

        } else {

            DB::table('cart_items')->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}