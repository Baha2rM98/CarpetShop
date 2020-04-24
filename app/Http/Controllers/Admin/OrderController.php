<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use App\Product;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Retrieves all orders
     *
     * @return View
     */
    public function getOrders()
    {
        $orders = Order::withTrashed()->with([
            'products', 'payment', 'coupon', 'address.province', 'address.city',
            'user' => function ($query) {
                $query->withTrashed();
            }
        ])->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Retrieves products of each order
     *
     * @param  int  $id
     * @return View
     */
    public function getOrderDetails($id)
    {
        $order = Order::findOrFail($id);

        $products = Product::withTrashed()->with('photos')
            ->whereHas('orders', function ($query) use ($id) {
                $query->where('order_id', $id);
            })->get();

        $pivots = OrderProduct::where('order_id', $id)->get();

        return view('admin.orders.order-products', compact('order', 'products', 'pivots'));
    }
}
