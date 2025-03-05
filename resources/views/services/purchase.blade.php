@extends('layout')

@section('title', 'Detalle del Producto')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <!-- Imagen estática del producto -->
                <img src="{{ asset('images/default.jpg') }}" alt="Imagen del producto" class="card-img-top img-fluid" style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <!-- Detalles del producto -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Nombre del producto -->
                    <h2 class="card-title text-primary">Nombre del Producto</h2>
                    <!-- Descripción corta -->
                    <p class="card-text text-muted">Descripción breve del producto.</p>
                    <!-- Precio -->
                    <h4 class="text-success">Precio: $99.99</h4>
                    <!-- Disponibilidad -->
                    <p class="text-secondary">Disponible: <span class="text-success">En stock</span></p>

                    <!-- Selector de cantidad -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad:</label>
                        <input type="number" class="form-control" id="quantity" min="1" max="10" value="1">
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg">
                            <i class="bi bi-cart-plus"></i> Añadir al carrito
                        </button>
                        <button class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Seguir comprando
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Descripción adicional -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-primary">Descripción detallada</h4>
                    <p class="card-text text-muted">Descripción detallada del producto. Aquí puedes incluir más información sobre las características, especificaciones y detalles adicionales.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Función para añadir al carrito (comentada para evitar errores)
    /*
    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        const productId = "{{-- $product->id --}}";

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{-- csrf_token() --}}'
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto añadido al carrito');
            } else {
                alert('Error al añadir el producto al carrito');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    */

    // Función para seguir comprando (comentada para evitar errores)
    /*
    function continueShopping() {
        window.location.href = '/products';
    }
    */
</script>
@endsection