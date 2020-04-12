<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders()
    {
        $orders = Order::paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
}
