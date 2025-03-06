@extends('layout')

@section('title', 'Detalle del Producto')

@section('content')
<!-- Sección principal con fondo blanco -->
<section class="bg-white py-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/services">Servicios</a></li>
            <li class="breadcrumb-item active underline" aria-current="page">Nombre del producto</li>
          </ol>
        </nav>
        <div class="row align-items-stretch"> <!-- Asegura que las columnas tengan la misma altura -->
            <!-- Imagen del producto -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100"> <!-- h-100 para que ocupe toda la altura -->
                    <!-- Imagen estática del producto -->
                    <img src="{{ asset('images/default.jpg') }}" alt="Imagen del producto" class="card-img-top img-fluid" style="height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Detalles del producto -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100"> <!-- h-100 para que ocupe toda la altura -->
                    <div class="card-body d-flex flex-column"> <!-- Flexbox para alinear el contenido -->
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
                        <div class="d-grid gap-2 mt-auto"> <!-- mt-auto para alinear los botones al final -->
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
</section>
<section class="destacados-section p-3"> <!-- Reducir el padding -->
    <div class="container"> <!-- Añadir un contenedor para limitar el ancho -->
        <h4 class="text-center mb-4 fs-2 text-black">Similares</h4>
        <p class="text-center text-muted mb-4 fs-5">Elige de nuestros usuarios más populares</p> <!-- Reducir el tamaño del texto -->
        <div class="row justify-content-center text-black"> <!-- Centrar las cartas -->
            @foreach ([
                ['nombre' => 'Lucas Pérez', 'tag' => 'Popular', 'desc' => 'Diseño interfaces atractivas y responsivas con React y Tailwind.'],
                ['nombre' => 'Ana Torres', 'tag' => 'Tendencia', 'desc' => 'Desarrollo backends seguros y escalables con Node.js y PostgreSQL.'],
                ['nombre' => 'Martín Rojas', 'tag' => 'Mejor valorado', 'desc' => 'Construyo webs completas, desde el frontend hasta el backend.']
            ] as $usuario)
                <div class="col-md-4 mb-4"> <!-- Ajustar el número de columnas y añadir margen inferior -->
                    <div class="profile-card bg-white p-3 shadow-sm"> <!-- Añadir sombra para coincidir con el estilo -->
                        <span class="tag fs-5"> <!-- Reducir el tamaño del texto -->
                            @if ($usuario['tag'] == 'Popular')
                                &#11088; <!-- ⭐ -->
                            @elseif ($usuario['tag'] == 'Tendencia')
                                &#128293; <!-- 🔥 -->
                            @elseif ($usuario['tag'] == 'Mejor valorado')
                                &#127942; <!-- 🏆 -->
                            @endif
                            {{ $usuario['tag'] }}
                        </span>
                        <div class="profile-image text-center my-3">
                            <img src="{{ asset('images/computer.png') }}" 
                                alt="Profile Image" class="img-fluid" style="max-height: 150px;"> <!-- Reducir el tamaño de la imagen -->
                        </div>
                        <p class="fs-6 fw-bold mb-2">{{ $usuario['nombre'] }}</p> <!-- Reducir el tamaño del texto -->
                        <p class="text-muted fs-6 mb-3">{{ $usuario['desc'] }}</p> <!-- Reducir el tamaño del texto -->
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary btn-sm">Ver perfil</button> <!-- Reducir el tamaño del botón -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

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