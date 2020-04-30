<?php

namespace App\SMSPanel;

use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;

class SMS
{
    /**
     * Sends the message
     *
     * @param  string  $message
     * @param  string  $receiver
     * @return bool
     */
    public static function send($message, $receiver)
    {
        try {
//            $apiKey = env('API_KEY');
//            $sender = env('SMS_SENDER');
            $apiKey = env('7A52765046754A573557446130373167365A5561756450416C6438793232464D415047774B49434659416B3D');
            $sender = env('1000596446');
            $panel = new KavenegarApi($apiKey);
            $panel->Send($sender, $receiver, $message);
        } catch (ApiException $apiException) {
            return false;
        } catch (HttpException $httpException) {
            return false;
        }

        return true;
    }

    /**
     * Sends the message surly (grantees the sms will be delivered)
     *
     * @param  string  $template
     * @param  string  $receiver
     * @param  string  $token
     * @return bool
     */
    public static function forceSend($template, $receiver, $token)
    {
        try {
            $apiKey = env('API_KEY');
            $panel = new KavenegarApi($apiKey);
            $panel->VerifyLookup($receiver, $token, '', '', $template);
            return true;
        } catch (ApiException $apiException) {
            return false;
        } catch (HttpException $httpException) {
            return false;
        }
    }
}
