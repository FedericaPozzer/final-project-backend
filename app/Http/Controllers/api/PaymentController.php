<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Dish;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function token(Request $request){
        $data = $request->all();

        $order = new Order;

        $order->guest_name = $data['user_name'];
        $order->guest_address = $data['user_address'];
        $order->guest_mail = $data['user_email'];

        $order->guest_phone_number = $data['user_phone'];
        $order->amount = $data['amount'];
        foreach($data['dishes'] as $dish){
            $dbDish = Dish::all()->where('id', '=', $dish['id'])->first();
            $dbDish->orders()->save($order, ['quantity' => $dish['quantity']]);
            $order->restaurant()->associate($dbDish->restaurant);
        }

        $dbDish->restaurant->sendMailToCustomer($data['user_email']);
        $dbDish->restaurant->sendMailToRestaurant();

        $order->save();

        $gateway = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'wbf3cy8nk8xrp2n2',
            'publicKey' => "gcshkmwdhdrg49tc",
            'privateKey' => 'c818611491dbbca4c96a9eba96afe06d'
        ]);

        $result = $gateway->transaction()->sale([
            'amount' => $data['amount'],
            'paymentMethodNonce' => $data['nonce'],
            'options' => [
                'submitForSettlement' => True
            ]
        ]);
        $order->success = 1;
        return $result;
    }

    public function SendMail($customer_mail){
        return to_route('customer.mail', $customer_mail);
    }
}
