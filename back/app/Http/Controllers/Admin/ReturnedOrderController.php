<?php

namespace App\Http\Controllers;

use App\Models\ReturnedOrder;  // مدل مرجوعی‌ها
use Illuminate\Http\Request;

class ReturnedOrderController extends Controller
{
    public function index()
    {
        // دریافت داده‌های مرجوعی‌ها
        $returnedOrders = ReturnedOrder::all();  // یا هر کوئری که مناسب باشد

        return view('admin.returned-orders.index', compact('returnedOrders'));
    }
}
