<?php

namespace App\Http\Controllers;

use App\Models\ReturnedOrder;  // مدل مرجوعی‌ها
use Illuminate\Http\Request;
use App\Models\ProductOrder;

class ReturnedOrderController extends Controller
{
    public function index()
    {
        // دریافت سفارش‌های مرجوعی از مدل ProductOrder
        $returnedOrders = ProductOrder::where('status', 'REFERRED')->get();

        return view('admin.product-returned.index', compact('returnedOrders'));
    }


}
