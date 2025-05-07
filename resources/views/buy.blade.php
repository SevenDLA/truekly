@extends('layout')

@section('content')
<div id="messageBox" class="">
</div>


<div class="d-flex justify-content-between gap-3">
    {{-- Left side: Order Review --}}
    <div class="w-50 p-3 border rounded bg-light">
        <a href="/" class="d-block mb-2 text-primary text-decoration-none">&larr; Regresar</a>
        <h2>Revisa tu pedido</h2>
        <p>Este es un resumen de tu pedido para asegurarnos de que adquieres lo que realmente buscas.</p>
        
        <div class="d-flex align-items-center justify-content-center border p-2 rounded bg-white">
            <img src="{{ asset('images/coin.png') }}" alt="Tokens" class="img-fluid" style="width: 80px; height: 80px;">
            <div class="ms-3 text-center">
                <strong>Cantidad: {{$cantidad_tokens}} tokens</strong>
                <p>Precio: {{ $precio_tokens }}€</p>
                <p>Vendedor: {{ $seller ? $seller->username : 'Truekly' }}</p>
            </div>
        </div>
    </div>

    {{-- Right side: Payment Details --}}
    <div class="w-50 d-flex justify-content-center align-items-center p-3">
        <div class="w-100" style="max-width: 300px;" id="paymentDiv">
            <div id="paypal-button-container"></div>
        </div>
    </div>
</div>



<script src="https://www.paypal.com/sdk/js?client-id=AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23&currency=EUR" data-sdk-integration-source="button-factory"></script>


<script>

    paypal.Buttons({
        style: {
            size: 'large',
            color: 'gold',
            shape: 'rect',
            label: 'checkout'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: { value: '{{ $precio_tokens }}' },
                    description: 'TokenSkills'
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {

                
                if (details.purchase_units && details.purchase_units.length > 0) 
                {
                    // Safely access the amount from the first purchase unit
                    const cantidad = details.purchase_units[0].amount.value;
                    console.log("Amount: ", cantidad);

                    let seller = @json($seller);
                    console.log("Seller email: ", seller ? seller.email : "No seller");

                    // Perform your payout operation here...
                    buyFromSeller(details, cantidad);
                } 
                else 
                {
                    console.error("purchase_units is empty or missing.");
                }



            });
        }
    }).render('#paypal-button-container');



    function buyFromSeller(details, cantidad)
    {
        $.ajax({
                    url: "{{ route('send.paypal.payout') }}",  // Replace with the actual route for sending a PayPal payout
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // Laravel CSRF token for security
                        receiverEmail: "{{ $seller ? $seller->email : 'default@example.com' }}",
                        amount: cantidad,  // Amount to send in EUR
                        note: 'Gracias por tus tokens!'  // Optional note
                    },
                    success: function(response) {
                        // Check if the payout was successful
                        if (response.batch_header && response.batch_header.batch_status === 'PENDING') {
                            $('#messageBox')
                                .text("Tu pago está pendiente de procesarse.") 
                                .css({
                                    'background-color': 'orange',
                                    'color': 'white',
                                    'font-weight': 'bold',
                                    'text-align': 'center',
                                    'padding': '10px',
                                    'width': '100%'
                                })
                                .show();
                            
                                updateUserTokens()
                                updateOfferStatus()

                            // Optionally, reload or perform other actions after a successful payout creation
                            setTimeout(function() {
                                window.location.href="{{ route('profile.normal') }}";
                            }, 3000);
                        } else {
                            $('#messageBox')
                                .text("Hubo un error con el pago.") 
                                .css({
                                    'background-color': 'red',
                                    'color': 'white',
                                    'font-weight': 'bold',
                                    'text-align': 'center',
                                    'padding': '10px',
                                    'width': '100%'
                                })
                                .show();
                            console.log(response)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error processing payout:", error);
                        alert("Hubo un error al procesar el pago. Intenta nuevamente.");
                    }
                });
    }

    function buyFromCompany(details)
    {
        console.log(details);

        $('#messageBox')
                    .html('Tu compra ha sido realizada!') // Add the message
                    .removeClass('d-none') // Remove the "d-none" class (if using Bootstrap)
                    .addClass('d-flex justify-content-center align-items-center fw-bold text-white bg-success w-100 p-2') // Add styling classes
                    .hide() // Hide the div initially
                    .fadeIn(500) // Fade in the div over 500ms
                    .delay(2000) // Keep it visible for 2 seconds
                    .fadeOut(500, function() {
                        // Optional: Reset the div after fading out
                        $(this).removeClass().addClass('d-none').html('');
                    });

        updateUserTokens()
    }


    function updateOfferStatus()
    {
        $.ajax({
            url: "{{ route('offer.status.update') }}",
            method: 'POST',
            data:
            {
                _token: '{{ csrf_token() }}',
                offerId: "{{ $offer->id }}"

            },
            success: function(response)
            {
                console.log('Estado de la oferta actualizada con éxito');
            },
            error: function(error)
            {
                console.error('Error actualizando: ', error);
            }
        })
    }

    function updateUserTokens()
    {
        // Update the user's tokens after successful payment
        const newTokens = {{ auth()->user()->tokens }} + {{ $cantidad_tokens }};
        console.log('New Tokens:', newTokens);

        // Send an AJAX request to update the user's tokens in the database
        $.ajax({
            url: '/actualizar-tokens',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                tokens: newTokens
            },
            success: function(response) {
                console.log('Tokens updated successfully')
            },
            error: function(error) {
                console.error('Error updating tokens:', error);
            }
        });
    }

    function purchaseCompleted(){
        $('#paymentDiv').html('Works');
        $('#messageBox').html('')
    }

</script>
@endsection