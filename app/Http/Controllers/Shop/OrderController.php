<?php

namespace App\Http\Controllers\Shop;

use App\CouponUser;
use App\Order;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use BlackPlatinum\Zarinpal\Zarinpal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
        $cart = Session::get('cart');
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
            if (Session::get('applied')) {
                $coupon = CouponUser::where('user_id', $user->id)
                    ->join('coupons', 'coupons.id', 'coupon_user.coupon_id')
                    ->orderByDesc('coupon_user.created_at')->first();
                $order->coupon_id = $coupon ? $coupon->id : null;
                $order->coupon_discount = $coupon ? $coupon->price : null;
            }
            $order->order_code = $this->generateOrderCode();
            $order->user_id = $user->id;
            $order->address_id = $user->addresses()->where('primary', 1)->first()->id;
            $order->saveOrFail();
            $order->products()->attach($products);

            Session::put($user->email, false);

            $paymentRequest = (new Zarinpal(
                'request',
                [
                    'price' => $order->price,
                    'description' => 'فروشگاه اینترنتی کارپت مارکت',
                    'callbackUri' => 'checkout',
                    'orderId' => $order->id
                ], true
            ))->setMerchantId('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');
            $result = $paymentRequest->sendPaymentInfoToGateway();
            if ($result->Status == 100) {
                return redirect()->to($paymentRequest->linkToGateway($result->Authority));
            }

            return redirect()->route('order.failure');
        }

        $unpaidOrder = Order::where([['user_id', '=', $user->id], ['status', '=', 0]])->first();

        $paymentRequest = (new Zarinpal(
            'request',
            [
                'price' => $unpaidOrder->price,
                'description' => 'فروشگاه اینترنتی کارپت مارکت',
                'callbackUri' => 'checkout',
                'orderId' => $unpaidOrder->id
            ], true
        ))->setMerchantId('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');
        $result = $paymentRequest->sendPaymentInfoToGateway();
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
