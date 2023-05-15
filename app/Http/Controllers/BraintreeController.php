<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BraintreeController extends Controller
{
    public function token(Request $request){

        $data = $request->all();

        $gateway = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'ì5c8rdrw6bdrxnwnc',
            'publicKey' => 'xs7yg9vd6hqgtzn6',
            'privateKey' => 'b10d97a32f0fdc146cfcb01af6fb7770'
        ]);
        $nonceFromTheClient = $data['nonce'];
        $result = $gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        return $result;
    }
}
