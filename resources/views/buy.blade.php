@extends('layout')

@section('content')
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

        <h3>Opciones de pago</h3>
        <label><input type="radio" name="payment" checked> VISA</label>
        <label><input type="radio" name="payment"> PayPal</label>
    </div>

    {{-- Right side: Payment Details --}}
    <div style="width: 50%; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
        <h2>Detalles de la tarjeta</h2>

        <form action="" method="POST" style="display: grid; gap: 12px;">
            @csrf
            <div style="display: flex; gap: 10px;">
                <label style="flex: 1;">Nombre <input type="text" name="first_name" required style="width: 100%; padding: 8px;"></label>
                <label style="flex: 1;">Apellidos <input type="text" name="last_name" required style="width: 100%; padding: 8px;"></label>
            </div>

            <label>Número de tarjeta <input type="text" name="card_number" required style="width: 100%; padding: 8px;"></label>
            
            <div style="display: flex; gap: 10px;">
                <label style="flex: 1;">Fecha de caducidad <input type="text" name="expiry_date" required style="width: 100%; padding: 8px;"></label>
                <label style="flex: 1;">CVC <input type="text" name="cvc" required style="width: 100%; padding: 8px;"></label>
            </div>

            <label>Destino factura <input type="text" name="billing_address" required style="width: 100%; padding: 8px;"></label>
            
            <div style="display: flex; gap: 10px;">
                <label style="flex: 1;">Ciudad <input type="text" name="city" required style="width: 100%; padding: 8px;"></label>
                <label style="flex: 1;">País <input type="text" name="country" required style="width: 100%; padding: 8px;"></label>
            </div>

            <div style="display: flex; gap: 10px;">
                <label style="flex: 1;">Código postal <input type="text" name="zip_code" required style="width: 100%; padding: 8px;"></label>
                <label style="flex: 1;">Número de teléfono <input type="text" name="phone" required style="width: 100%; padding: 8px;"></label>
            </div>

            <button type="submit" style="background-color: black; color: white; padding: 12px; border: none; cursor: pointer; font-size: 16px; border-radius: 5px;">Finalizar pedido</button>
        </form>
    </div>
</div>
@endsection
