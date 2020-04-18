<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Order;
use App\Payment;
use App\Payments\PaymentVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SoapFault;
use Throwable;

class PaymentController extends Controller
{
    /**
     * Verifies the user cart
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws Throwable
     * @throws SoapFault
     */
    public function paymentVerification(Request $request, $id)
    {
        $cart = $request->session()->get('cart');

        $authority = $request->input('Authority');
        $status = $request->input('Status');

        $paymentVerification = new PaymentVerification([
            'merchantId' => 'X',
            'price' => $cart->totalPrice,
            'authority' => $authority
        ]);

        $paymentVerification->enableSandBox();
        $result = $paymentVerification->receivePaymentInfo($status);
        if ($result) {
            $order = Order::findOrFail($id);
            $order->status = 1;
            $order->saveOrFail();

            $payment = new Payment();
            $payment->authority = $authority;
            $payment->status = $status;
            $payment->refId = $result->RefID;
            $payment->order_id = $id;
            $payment->saveOrFail();

            $request->session()->forget(['cart', $request->user()->email]);

            return redirect()->route('user.dashboard')->with([
                'success' => 'پرداخت شما با موفقیت انجام شد! می توانید تاریخچه سفارشات خود را مشاهده نمایید.'
            ]);
        }

        return redirect()->route('cart.cart')->with([
            'fail' => 'خطایی در پرداخت شما به وجود آمده است، لطفا مجددا تلاش کنید.'
        ]);
    }
}
