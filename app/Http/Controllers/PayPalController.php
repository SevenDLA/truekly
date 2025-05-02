<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Facades\PayPal;

class PayPalController extends Controller
{
    public function createPayment()
    {
        $paypal = PayPal::setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $order = $paypal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"  // total cost from User1
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel')
            ]
        ]);

        return redirect($order['links'][1]['href']); // PayPal approval link
    }

    public function capturePayment(Request $request)
    {
        $paypal = PayPal::setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $orderId = $request->get('token');
        $capture = $paypal->capturePaymentOrder($orderId);

        // Payment succeeded, now do payout to User2
        $this->sendPayoutToSeller();

        return response()->json(['message' => 'Payment complete and payout sent!']);
    }

    protected function sendPayoutToSeller()
    {
        $paypal = PayPal::setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $payout = $paypal->createBatchPayout([
            "sender_batch_header" => [
                "sender_batch_id" => uniqid(),
                "email_subject" => "You have a payment"
            ],
            "items" => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => "90.00", // e.g. 100 - 10 commission
                        "currency" => "USD"
                    ],
                    "receiver" => "seller-sandbox-email@example.com",
                    "note" => "Thanks for your service!",
                    "sender_item_id" => "item_1"
                ]
            ]
        ]);

        return $payout;
    }
}
