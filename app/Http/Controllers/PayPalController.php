<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  // <-- Correct import for Http Facade
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Offer;

class PayPalController extends Controller
{
    public static function sendPaypalPayout(Request $request)
    {
        // Coger datos del AJAX
        $receiverEmail = $request->input('receiverEmail');
        $amount = $request->input('amount');
        $note = $request->input('note', 'Gracias!');  // Default note if none provided
        $comision = $request->input('comision');
        $comision = $comision ? 0.1 : 0;
        $total = $amount - ($amount * $comision);
        // Paso 1: Coger Access Token
        $tokenResponse = Http::withBasicAuth(
            config('paypal.client_id'),
            config('paypal.client_secret')
        )->asForm()->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);
    
        $accessToken = $tokenResponse['access_token'];
    
        // Paso 2: Mandar pago
        $payoutResponse = Http::withToken($accessToken)->post('https://api-m.sandbox.paypal.com/v1/payments/payouts', [
            "sender_batch_header" => [
                "sender_batch_id" => uniqid(),
                "email_subject" => "Has recibido un pago!",
                "email_message" => "Has vendido tus tokens correctamente.",
            ],
            "items" => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => number_format($total, 2),
                        "currency" => "EUR"
                    ],
                    "note" => $note,
                    "sender_item_id" => uniqid(),
                    "receiver" => $receiverEmail
                ]
            ]
        ]);
    
        // Return the response as JSON
        return response()->json($payoutResponse->json());
    }
    
}
