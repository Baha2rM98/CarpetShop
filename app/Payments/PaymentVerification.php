<?php

namespace App\Payments;

use SoapClient;
use SoapFault;

class PaymentVerification
{
    /**
     * @var string the Gateway id
     */
    private $merchantId;

    /**
     * @var double The total price of order
     */
    private $price;

    /**
     * @var string The Authority code
     */
    private $authority;

    /**
     * @var string The payment request url
     */
    private $paymentRequest;

    /**
     * Create an instance of PaymentVerification
     *
     * @param  array  $paymentData
     */
    public function __construct(array $paymentData)
    {
        $this->merchantId = $paymentData['merchantId'];
        $this->price = $paymentData['price'];
        $this->authority = $paymentData['authority'];
        $this->paymentRequest = 'https://www.zarinpal.com/pg/services/WebGate/wsdl';
    }

    /**
     * Receive payment information from zarinpal gateway
     *
     * @param  string  $status
     * @return object|array|bool
     * @throws SoapFault
     */
    public function receivePaymentInfo($status)
    {
        if ($status == 'OK') {
            $client = new SoapClient($this->paymentRequest, ['encoding' => 'UTF-8']);

            return $client->PaymentVerification(
                [
                    'MerchantID' => $this->merchantId,
                    'Authority' => $this->authority,
                    'Amount' => $this->price
                ]
            );
        }

        return false;
    }

    /**
     * Enables sandbox mode (testing)
     *
     * @return void
     */
    public function enableSandBox()
    {
        $this->paymentRequest = 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl';
    }
}
