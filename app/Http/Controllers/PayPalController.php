<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Facades\PayPal;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;

class PayPalController extends Controller
{
    public function buyOffer(Request $request)
{
    $offerId = $request->input('offer_id');
    $offer = Offer::findOrFail($offerId); // Assuming you have an Offer model
    $buyer = auth()->user();
    $seller = User::find($offer->user_id);

    $businessCut = 0.1; // 10% cut
    $price = $offer->price;
    $sellerAmount = $price * (1 - $businessCut);

    // Create PayPal order
    $paypal = PayPal::setApiCredentials(config('paypal'));
    $token = $paypal->getAccessToken();
    $paypal->setAccessToken($token);

    $order = $paypal->createOrder([
        "intent" => "CAPTURE",
        "purchase_units" => [
            [
                "amount" => [
                    "currency_code" => "USD",
                    "value" => $price
                ]
            ]
        ],
        "application_context" => [
            "return_url" => route('paypal.success', ['offer_id' => $offerId]),
            "cancel_url" => route('paypal.cancel')
        ]
    ]);

    return redirect($order['links'][1]['href']); // Redirect to PayPal approval link
}

public function captureOfferPayment(Request $request)
{
    $offerId = $request->input('offer_id');
    $offer = Offer::findOrFail($offerId);
    $seller = User::find($offer->user_seller_id);

    $paypal = PayPal::setApiCredentials(config('paypal'));
    $token = $paypal->getAccessToken();
    $paypal->setAccessToken($token);

    $orderId = $request->get('token');
    $capture = $paypal->capturePaymentOrder($orderId);

    // Payment succeeded, send payout to seller
    $this->sendPayoutToSeller($seller, $offer->price);

    // Update offer status
    $offer->status = 'sold';
    $offer->save();

    return response()->json(['message' => 'Payment complete and payout sent!']);
}

protected function sendPayoutToSeller($seller, $amount)
{
    $businessCut = 0.1; // 10% cut
    $sellerAmount = $amount * (1 - $businessCut);

    $paypal = PayPal::setApiCredentials(config('paypal'));
    $token = $paypal->getAccessToken();
    $paypal->setAccessToken($token);

    $payout = $paypal->createBatchPayout([
        "sender_batch_header" => [
            "sender_batch_id" => uniqid(),
            "email_subject" => "You have received a payment"
        ],
        "items" => [
            [
                "recipient_type" => "EMAIL",
                "amount" => [
                    "value" => $sellerAmount,
                    "currency" => "USD"
                ],
                "receiver" => $seller->email, // Seller's PayPal email
                "note" => "Thanks for your offer!",
                "sender_item_id" => "item_" . $seller->id
            ]
        ]
    ]);

    return $payout;
}


public function sendPayout(Request $request)
{
    $client = new Client();

    // Step 1: Get OAuth token
    $authResponse = $client->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
        'auth' => ['AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23', 'ECNhvA5yCRvvr5S2yNqhMxwzk9oC8XFW7_dZ5pHz052HAfxmkggs9x8FcIjnycndBJ8PQ50G7-RvyEnA'],
        'form_params' => ['grant_type' => 'client_credentials'],
    ]);

    $accessToken = json_decode($authResponse->getBody(), true)['access_token'];

    // Step 2: Send Payout
    $response = $client->post('https://api-m.sandbox.paypal.com/v1/payments/payouts', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessToken",
        ],
        'json' => [
            'sender_batch_header' => [
                'sender_batch_id' => uniqid(),
                'email_subject' => 'You have received a payout!',
            ],
            'items' => [
                [
                    'recipient_type' => 'EMAIL',
                    'amount' => [
                        'value' => number_format($request->euros, 2),
                        'currency' => 'EUR',
                    ],
                    'receiver' => $request->paypal_email,
                    'note' => 'Thanks for your tokens!',
                ]
            ]
        ]
    ]);

    return response()->json(['status' => 'ok']);
}

}
