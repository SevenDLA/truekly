@extends('layout')

@section('content')
<div style="display: flex; justify-content: space-between; gap: 20px;">
    
    {{-- Left side: Order Review --}}
    <div style="width: 50%; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <a href="#" style="display: block; margin-bottom: 10px;">← Regresar</a>
        <h2>Revisa tu pedido</h2>
        <p>Este es un resumen de tu pedido para asegurarnos de que adquieres lo que realmente buscas.</p>
        
        <div style="display: flex; align-items: center; border: 1px solid #ddd; padding: 10px; border-radius: 8px;">
            <img src="{{ asset('images/tokens.png') }}" alt="Tokens" style="width: 80px; height: 80px;">
            <div style="margin-left: 10px;">
                <strong>200 TokenSkills</strong>
                <p>9 €</p>
            </div>
        </div>

        <h3>Opciones de pago</h3>
        <label><input type="radio" name="payment" checked> VISA</label><br>
        <label><input type="radio" name="payment"> PayPal</label>
    </div>

    {{-- Right side: Payment Details --}}
    <div style="width: 50%; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2>Detalles de la tarjeta</h2>

        <form action="" method="POST">
            @csrf
            <label>Nombre <input type="text" name="first_name" required></label>
            <label>Apellidos <input type="text" name="last_name" required></label>

            <label>Número de tarjeta <input type="text" name="card_number" required></label>
            <label>Fecha de caducidad <input type="text" name="expiry_date" required></label>
            <label>CVC <input type="text" name="cvc" required></label>

            <label>Destino factura <input type="text" name="billing_address" required></label>
            <label>Ciudad <input type="text" name="city" required></label>

            <label>País <input type="text" name="country" required></label>
            <label>Código postal <input type="text" name="zip_code" required></label>

            <label>Número de teléfono <input type="text" name="phone" required></label>

            <button type="submit" style="background-color: black; color: white; padding: 10px 20px; border: none; cursor: pointer;">Finalizar pedido</button>
        </form>
    </div>

</div>
@endsection
