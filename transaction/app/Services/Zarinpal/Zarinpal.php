<?php

namespace App\Services\Zarinpal;

use Illuminate\Support\Facades\Config;

class Zarinpal
{
    public $MerchantID;

    public function __construct()
    {
        $this->MerchantID = Config::get('app.MERCHANTID');
    }

    public function payment($amount, $email, $mobile)
    {
        $description = trans('label.increase_credit');  // required
        $callbackUrl = url('/order'); // required

        $client = new \SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest('PaymentRequest', [
            [
                'MerchantID' => $this->MerchantID,
                'Amount' => $amount,
                'Description' => $description,
                'Email' => $email,
                'Mobile' => $mobile,
                'CallbackURL' => $callbackUrl,
            ],
        ]);

        //redirect to URL U can do it also by creating a form
        if ($result['Status'] == 100) {
            return $result->Authority;

        } else {
            return "ERR :" . $result->Status;
        }
    }

}
