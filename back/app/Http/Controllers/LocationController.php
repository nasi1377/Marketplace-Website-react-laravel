<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function provinces()
    {
        return response()->json(
            DB::table('provinces')
                ->orderBy('name')
                ->get()
        );
    }

    public function cities($provinceId)
    {
        return response()->json(
            DB::table('cities')
                ->where('province_id', $provinceId)
                ->orderBy('name')
                ->get()
        );
    }
}