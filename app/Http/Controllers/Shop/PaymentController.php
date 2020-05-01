<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Order;
use App\Payment;
use BlackPlatinum\Zarinpal\Zarinpal;
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
        $authority = $request->input('Authority');
        $status = $request->input('Status');

        $order = Order::findOrFail($id);

        $paymentResponse = (new Zarinpal(
            'response',
            [
                'price' => $order->price,
                'authority' => $authority
            ], true
        ))->setMerchantId('XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX');
        $result = $paymentResponse->receivePaymentInfoFromGateway($status);
        if ($result) {
            $order->status = 1;
            $order->saveOrFail();

            $payment = new Payment();
            $payment->authority = $authority;
            $payment->status = $status;
            $payment->refId = $result->RefID;
            $payment->order_id = $id;
            $payment->saveOrFail();

            $request->session()->forget([$request->user()->email, 'cart', 'applied']);

            return redirect()->route('user.dashboard')->with(
                [
                    'success' => 'پرداخت شما با موفقیت انجام شد! می توانید تاریخچه سفارشات خود را مشاهده نمایید.'
                ]
            );
        }

        return redirect()->route('cart.cart')->with(
            [
                'fail' => 'خطایی در پرداخت شما به وجود آمده است، لطفا مجددا تلاش کنید.'
            ]
        );
    }
}
