@extends('layout')

@section('title', 'Intercambia Tokens')
@vite(['resources/js/profile.js'])
@section('content')
<div id="messageBox"></div>
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="container text-center">
        <a href="javascript:history.back()" class="btn btn-link">&larr; Regresar</a>
        <h2 class="mt-3">Intercambia tus tokens por dinero o <a href="/oferta">haz una oferta para el marketplace</a></h2>

        <div class="card mx-auto mt-3 p-4 shadow" style="max-width: 400px;">
            <div class="d-flex justify-content-center">
                <img src="{{ asset('images/coin.png') }}" alt="Tokens" class="img-fluid" style="width: 100px;">
            </div>
            <div class="mt-3">
                <label for="tokens">TokenSkills:</label>
                <input type="number" id="tokens" class="form-control text-center" value="0" onchange="calcularEuros()">
                <p id="tokensMessageBox"></p>
            </div>
            <div class="mt-3">
                <label for="euros">Euros:</label>
                <input type="number" id="euros" class="form-control text-center" value="0" readonly>
            </div>
            <p class="mt-2">1 TokenSkill equivale a aproximadamente 0,05 €</p>
            
            <!-- PayPal Button Container -->
            <div id="paypal-button-container" class="mt-3"></div>
        </div>
    </div>
</div>

<!-- Include PayPal SDK (Sandbox Version) -->
<script src="https://www.paypal.com/sdk/js?client-id=AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23&currency=EUR&intent=capture"></script>

<script>
    function calcularEuros() {
        let tokens = parseFloat($('#tokens').val());
            let euroValue = tokens * 0.05;
            $('#euros').val(euroValue.toFixed(2));
    }

    function showMessage(message='') {
        message==''?$('#tokens').css('border-color', 'black'):$('#tokens').css('border-color', 'red');
        $('#tokensMessageBox').css('color', 'red')
        $('#tokensMessageBox').html(message)
    }

    function validateErrors(tokens) {
        let isValid = true;
        let message = '';

        const validConditions = [
            {
                check: !isNaN(tokens), // Check if tokens is not NaN
                message: 'Sólo puede ser numérico'
            },
            {
                check: tokens >= 250, // Check if tokens is at least 250
                message: 'Tiene que haber como mínimo, 250 tokens'
            },
            {
                check: parseFloat(tokens) <= {{ Auth::user()->tokens }}, // Check if tokens is not more than the user's available tokens
                message: 'Tokens insuficientes'
            }
        ];

        for (const condition of validConditions) {
            if (!condition.check) {
                isValid = false;
                message = condition.message;
                console.log({{Auth::user()->tokens}})
                break;
            }
        }
        showMessage(message);
        return isValid;
    }


    $(document).ready(function () {
    paypal.Buttons({
        onInit: function (data, actions) {
            actions.disable(); // Initially disable the button

            $('#tokens').on('input', function () {
                let tokens = parseFloat($(this).val());
                let valid = validateErrors(tokens); // Assumes validateErrors() is defined elsewhere
                if (valid) {
                    actions.enable();
                } else {
                    actions.disable();
                }
            });
        },

        createOrder: function (data, actions) {
            // Create a dummy order with 1 EUR to satisfy PayPal
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '1.00' // Placeholder, the real payout is handled via AJAX
                    }
                }]
            });
        },

        onApprove: function (data, actions) {
            let tokens = parseFloat($('#tokens').val());
            let euros = parseFloat($('#euros').val());

            let paypalEmail = prompt("Introduce tu correo de PayPal para recibir el pago:");

            if (!paypalEmail || !paypalEmail.includes("@")) {
                alert("Correo de PayPal no válido.");
                return;
            }

            // Send payout request to backend
            return $.ajax({
                url: "{{ route('send.payout') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tokens: tokens,
                    euros: euros,
                    paypal_email: paypalEmail
                },
                success: function (response) {
                    $('#messageBox')
                        .text("¡Payout enviado exitosamente!")
                        .css({
                            'background-color': 'green',
                            'color': 'white',
                            'font-weight': 'bold',
                            'text-align': 'center',
                            'padding': '10px',
                            'width': '100%'
                        })
                        .show();

                    setTimeout(function () {
                        location.reload();
                    }, 5000);
                },
                error: function (xhr, status, error) {
                    console.error("Error al procesar payout:", error);
                    alert("Hubo un error enviando el payout. Intenta de nuevo.");
                }
            });
        },

        onError: function (err) {
            console.error("Error triggering payout:", err);
            alert("Error inesperado. Intenta de nuevo.");
        }
    }).render('#paypal-button-container');
});




    $('#tokens').on('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();  // Prevent Enter key action on keydown
    }
});
</script>
@endsection