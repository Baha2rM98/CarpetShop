<?php

namespace App\Payments;

use SoapClient;
use SoapFault;

class PaymentRequest
{
    /**
     * @var bool Check if we are in developing mode
     */
    private $isDevelopingMode = false;

    /**
     * @var string The Gateway id
     */
    private $merchantId;

    /**
     * @var double The total price of order
     */
    private $price;

    /**
     * @var string The transaction description
     */
    private $description;

    /**
     * @var string The route that user will be redirected after payment
     */
    private $callbackUrl;

    /**
     * @var string The payment request url
     */
    private $paymentRequest;

    /**
     * @var string The payment request url
     */
    private $gateWayUrl;

    /**
     * Create an instance of PaymentRequest
     *
     * @param  array  $paymentData
     * @param  int  $orderId
     */
    public function __construct(array $paymentData, $orderId)
    {
        $this->merchantId = $paymentData['merchantId'];
        $this->price = $paymentData['price'];
        $this->description = $paymentData['description'];
        $this->callbackUrl = env('app_url').'/checkout/'.$orderId;
        $this->paymentRequest = 'https://www.zarinpal.com/pg/services/WebGate/wsdl';
        $this->gateWayUrl = 'https://www.zarinpal.com/pg/StartPay/';
    }

    /**
     * Sends payment information to zarinpal gateway
     *
     * @throws SoapFault
     */
    public function sendPaymentInfo()
    {
        $client = new SoapClient($this->paymentRequest, ['encoding' => 'UTF-8']);

        return $client->PaymentRequest(
            [
                'MerchantID' => $this->merchantId,
                'Amount' => $this->price,
                'Description' => $this->description,
                'CallbackURL' => $this->callbackUrl
            ]
        );
    }

    /**
     * Links our application to zarinpal gateway
     *
     * @param $authority
     * @return string
     */
    public function linkToGateway($authority)
    {
        if ($this->isDevelopingMode) {
            return $this->gateWayUrl.$authority;
        }
        return $this->gateWayUrl.$authority.'/ZarinGate';
    }

    /**
     * Enables sandbox mode (testing)
     *
     * @return void
     */
    public function enableSandBox()
    {
        $this->isDevelopingMode = true;
        $this->paymentRequest = 'https://sandbox.zarinpal.com/pg/services/WebGate/wsdl';
        $this->gateWayUrl = 'https://sandbox.zarinpal.com/pg/StartPay/';
    }
}
