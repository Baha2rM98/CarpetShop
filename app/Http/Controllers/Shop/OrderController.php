<?php

namespace App\Http\Controllers\Shop;

use App\Coupon;
use App\Order;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Throwable;

class OrderController extends Controller
{
    use Helper;

    /**
     * @param  Request  $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function paymentVerified(Request $request)
    {
        $cart = Session::has('cart') ? Session::get('cart') : null;
        if (is_null($cart)) {
            return back()->with(['emptyCart' => 'سبد خرید شما خالی است!']);
        }

        $products = [];
        foreach ($cart->items as $product) {
            $products[$product['item']->id] = ['quantity' => $product['quantity']];
        }

        $user = $request->user();

        $order = new Order();
        $order->pure_price = $cart->totalPurePrice;
        $order->discount_price = $cart->totalDiscountPrice;
        $order->price = $cart->totalPrice;
        $coupon = Coupon::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->take(1)->first();
        $order->coupon_id = $coupon ? $coupon->id : null;
        $order->coupon_discount = $coupon ? $coupon->price : null;
        $order->order_code = $this->generateOrderCode();
        $order->user_id = $user->id;
        $order->uuid = Str::uuid();

        //
        $order->status = 1;
        //

        $order->saveOrFail();
        $order->products()->attach($products);
        $request->session()->forget(['cart', $user->email]);

        return redirect()->route('user.dashboard');
    }

    /**
     * Generates an individual identifier for each order
     *
     * @return string
     */
    private function generateOrderCode()
    {
        return 'CMO-'.$this->timestamp();
    }
}
