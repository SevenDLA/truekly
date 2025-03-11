@extends('layout')

@section('title', 'Intercambia Tokens')
@vite(['resources/js/profile.js'])
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="container text-center">
        <a href="javascript:history.back()" class="btn btn-link">&larr; Regresar</a>
        <h2 class="mt-3">Intercambia tus tokens por dinero</h2>

        <div class="card mx-auto mt-3 p-4 shadow" style="max-width: 400px;">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/coin.png') }}" alt="Tokens" class="img-fluid" style="width: 100px;">
            </div>
            <div class="mt-3">
                <label for="tokens">TokenSkills:</label>
                <input type="number" id="tokens" class="form-control text-center" value="500" onchange="calcularEuros()">
            </div>
            <div class="mt-3">
                <label for="euros">Euros:</label>
                <input type="number" id="euros" class="form-control text-center" value="25" readonly>
            </div>
            <p class="mt-2">1 TokenSkill equivale a aproximadamente 0,05 €</p>
            <button class="btn btn-primary w-100 mt-3" onclick="canjear()" >Canjear tokens</button>
        </div>
    </div>
</div>

<script>


    function calcularEuros() {
        let tokens = parseFloat($('#tokens').val()); // Convert input to a number
        if (isNaN(tokens)) {
            alert("Sólo se pueden introducir números")    
            $('#tokens').css('border-color', 'red')
            $('#tokens').val(0)
        }
        let euroValue = tokens * 0.05;
        $('#euros').val(euroValue.toFixed(2));
        return(euroValue.toFixed(2))
    }

    function canjear(){
        let tokensToSell = parseFloat($('#tokens').val());
        let valid = true;

        if (parseFloat($('#tokens').val()) < 250) {
                alert("Mínimo 250 tokens")
            $('#tokens').css('border-color', 'red'); // If the value is less than 250, set border color to red
            valid = false;
        }

        if(tokensToSell > {{Auth::user()->tokens}})
        {
            alert("Tokens insuficientes")
            valid = false;
        }


        if (valid){
            $('#tokens').css('border-color', 'green'); // Otherwise, set border color to green
            getAccessToken(function(token) {

            sendPayout(token);

            });

            $.ajax({
                url: "/actualizar-tokens",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: {
                    tokens: {{Auth::user()->tokens}}-tokensToSell, // Tokens sold
                    user_id: "{{ Auth::user()->id }}"
                },
                success: function(res) {
                    console.log("Tokens updated successfully:", res);
                    alert("Tus tokens han sido actualizados.");
                    location.reload(); // Refresh the page to update the token count
                },
                error: function(xhr) {
                    console.error("Error updating tokens:", xhr.responseText);
                }
            });


        }else{
            console.log("Unable to complete operation")
        }               

    }

    // PayPal API Credentials (Replace with your LIVE or SANDBOX credentials)
    const PAYPAL_CLIENT = "AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23"; 
    const PAYPAL_SECRET = "ECNhvA5yCRvvr5S2yNqhMxwzk9oC8XFW7_dZ5pHz052HAfxmkggs9x8FcIjnycndBJ8PQ50G7-RvyEnA";
    const PAYPAL_API = "https://api-m.sandbox.paypal.com"; // Use sandbox URL for testing: https://api-m.sandbox.paypal.com
    // Seller PayPal Email & Amount (Modify as needed)
    const sellerEmail = "sb-bdbbs38441050@business.example.com";  // Seller's PayPal email
    const payoutAmount = calcularEuros();              // Amount to send
    const currency = "EUR";                        // Currency
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
                        receiver: "{{Auth::user()->email}}",
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


</script>
@endsection
