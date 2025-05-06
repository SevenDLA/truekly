<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // <-- Correct import for Http Facade
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Offer;

class PayPalController extends Controller
{
    public static function sendPaypalPayout($receiverEmail, $amount, $note = 'Thanks!')
    {
        // Step 1: Get Access Token
        $tokenResponse = Http::withBasicAuth(
            config('paypal.client_id'),
            config('paypal.client_secret')
        )->asForm()->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        $accessToken = $tokenResponse['access_token'];

        // Step 2: Send Payout
        $payoutResponse = Http::withToken($accessToken)->post('https://api-m.sandbox.paypal.com/v1/payments/payouts', [
            "sender_batch_header" => [
                "sender_batch_id" => uniqid(),
                "email_subject" => "You have a payout!",
                "email_message" => "You have received a payment.",
            ],
            "items" => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => number_format($amount, 2),
                        "currency" => "EUR"
                    ],
                    "note" => $note,
                    "sender_item_id" => uniqid(),
                    "receiver" => $receiverEmail
                ]
            ]
        ]);

        return $payoutResponse->json();
    }
}
