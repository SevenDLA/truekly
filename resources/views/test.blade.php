@extends('layout')

@section('title', 'Mi Perfil')

@section('content')



    

    <script src="https://www.paypal.com/sdk/js?client-id=AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23&currency=EUR"></script>

<div id="paypal-button-container"></div>

<script>
    console.log("{{$offer->user_seller_id}}")
    console.log("Testing")
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: "{{ $offer->price }}" // Pass the offer price dynamically
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Send AJAX request to capture payment
                $.ajax({
                    url: "{{ route('paypal.captureOfferPayment') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        offer_id: "{{ $offer->id }}",
                        token: data.orderID
                    },
                    success: function(response) {
                        alert('Payment successful!');
                        location.reload();
                    },
                    error: function(error) {
                        console.error('Payment error:', error);
                    }
                });
            });
        }
    }).render('#paypal-button-container');
</script>
    <!--    PAYPAL WITHDRAW SYSTEM 
    
    <h2>PayPal Payout System</h2>
    
    <button id="withdraw">Withdraw Funds</button>

    <script>
        // PayPal API Credentials (Replace with your LIVE or SANDBOX credentials)
        const PAYPAL_CLIENT = "AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23"; 
        const PAYPAL_SECRET = "ECNhvA5yCRvvr5S2yNqhMxwzk9oC8XFW7_dZ5pHz052HAfxmkggs9x8FcIjnycndBJ8PQ50G7-RvyEnA";
        const PAYPAL_API = "https://api-m.sandbox.paypal.com"; // Use sandbox URL for testing: https://api-m.sandbox.paypal.com

        // Seller PayPal Email & Amount (Modify as needed)
        const sellerEmail = "sb-bdbbs38441050@business.example.com";  // Seller's PayPal email
        const payoutAmount = "10.00";              // Amount to send
        const currency = "EUR";                    // Currency

        // Function to get PayPal Access Token
        function getAccessToken(callback) {
            $.ajax({
                url: PAYPAL_API + "/v1/oauth2/token",
                method: "POST",
                headers: {
                    "Authorization": "Basic " + btoa(PAYPAL_CLIENT + ":" + PAYPAL_SECRET),
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                data: {
                    "grant_type": "client_credentials"
                },
                success: function(response) {
                    console.log("Access Token:", response.access_token);
                    callback(response.access_token);
                },
                error: function(xhr) {
                    console.error("Error Getting Access Token:", xhr.responseText);
                }
            });
        }

        // Function to Send Payout
        function sendPayout(accessToken) {
            $.ajax({
                url: PAYPAL_API + "/v1/payments/payouts",
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + accessToken,
                    "Content-Type": "application/json"
                },
                data: JSON.stringify({
                    sender_batch_header: {
                        email_subject: "You've received a payout!"
                    },
                    items: [
                        {
                            recipient_type: "EMAIL",
                            receiver: "sb-ralc438527279@personal.example.com",
                            amount: {
                                value: payoutAmount,
                                currency: currency
                            }
                        }
                    ]
                }),
                success: function(response) {
                    console.log("Payout Success:", response);
                    alert("Payout Sent Successfully!");
                },
                error: function(xhr) {
                    console.error("Payout Error:", xhr.responseText);
                }
            });
        }

        // Button Click to Withdraw Funds
        $("#withdraw").click(function() {
            getAccessToken(function(token) {
                sendPayout(token);
            });
        });

    </script>
                    -->

@endsection