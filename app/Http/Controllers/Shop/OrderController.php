<?php

namespace App\Http\Controllers\Shop;

use App\Coupon;
use App\Order;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Payments\PaymentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class OrderController extends Controller
{
    use Helper;

    /**
     * Returns failure view
     *
     * @return View
     */
    public function orderFailure()
    {
        return view('errors.payment-request-error');
    }

    /**
     * Verifies and save users's order
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function orderVerification(Request $request)
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

        if (!Order::whereHas('user', function ($query) use ($user) {
            $query->where([['user_id', '=', $user->id], ['status', '=', 0]]);
        })->exists()) {
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
            $order->saveOrFail();
            $order->products()->attach($products);

            $paymentRequest = new PaymentRequest([
                'merchantId' => 'X',
                'price' => $order->price,
                'description' => 'فروشگاه کارپت مارکت'
            ], $order->id);
            $paymentRequest->enableSandBox();
            $result = $paymentRequest->sendPaymentInfo();
            if ($result->Status == 100) {
                return redirect()->to($paymentRequest->linkToGateway($result->Authority));
            }
            return redirect()->route('order.failure');
        }

        $unpaidOrder = Order::where('user_id', $user->id)->latest()->take(1)->first();

        $paymentRequest = new PaymentRequest([
            'merchantId' => 'X',
            'price' => $unpaidOrder->price,
            'description' => 'فروشگاه کارپت مارکت'
        ], $unpaidOrder->id);
        $paymentRequest->enableSandBox();
        $result = $paymentRequest->sendPaymentInfo();
        if ($result->Status == 100) {
            return redirect()->to($paymentRequest->linkToGateway($result->Authority));
        }
        return redirect()->route('order.failure');
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
