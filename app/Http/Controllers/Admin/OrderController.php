<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.admin.index')->with([
            'orders' => Order::queryFilter()->get()
        ]);
    }
}
