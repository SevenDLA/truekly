@extends('layout')

@section('content')
<div id="messageBox">Completado</div>
<div style="display: flex; justify-content: space-between; gap: 20px;">
    {{-- Left side: Order Review --}}
    
<div style="width: 50%; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
        <a href="/" style="display: block; margin-bottom: 10px; color: #007bff; text-decoration: none;">&larr; Regresar</a>
        <h2>Revisa tu pedido</h2>
        <p>Este es un resumen de tu pedido para asegurarnos de que adquieres lo que realmente buscas.</p>
        
        <div style="display: flex; align-items: center; border: 1px solid #ddd; padding: 10px; border-radius: 8px; background: white;">
            <img src="{{ asset('images/coin.png') }}" alt="Tokens" style="width: 80px; height: 80px;">
            <div style="margin-left: 10px;">
                <strong>Cantidad: {{$cantidad_tokens}}</strong>
                <p>Precio: {{ $precio_tokens }}€</p>
            </div>
        </div>
</div>

    {{-- Right side: Payment Details --}}
    <div style="width: 50%; display: flex; justify-content: center; align-items: center; padding: 20px;">
        <div style="width: 100%; max-width: 300px;">
            <div id="paypal-button-container"></div>
        </div>
    </div>
</div>



<script src="https://www.paypal.com/sdk/js?client-id=AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23&currency=USD" data-sdk-integration-source="button-factory"></script>
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
                alert('Transaction completed by ' + details.payer.name.given_name);
                console.log(details);

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
                        console.log('Tokens updated successfully');
                        $('#messageBox').html("Success!");
                    },
                    error: function(error) {
                        console.error('Error updating tokens:', error);
                    }
                });
            });
}
    }).render('#paypal-button-container');
</script>
@endsection

