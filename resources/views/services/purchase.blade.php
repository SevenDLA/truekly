@extends('layout')

@section('title', $service->title)

@section('content')
<!--Cuadro de mensaje-->
<div id="messageBox"></div>


<!-- Sección principal con fondo blanco -->
<section class="bg-white py-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item"><a href="/servicios">Servicios</a></li>
                <li class="breadcrumb-item active underline" aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
        <div class="row align-items-stretch">
            <!-- Imagen del servicio -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <img src="{{ $service->image ? asset('storage/' . $service->image) : asset('images/default.jpg') }}" 
                         alt="Imagen de {{ $service->title }}" 
                         class="card-img-top img-fluid" 
                         style="height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Detalles del servicio -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title text-primary">{{ $service->title }}</h2>
                        <p class="card-text text-muted">{{ $service->short_description }}</p>
                        <h4 class="text-success">Precio: {{ number_format($service->price, 2) }} TokenSkills</h4>
                        <p class="text-secondary">Stock: 
                            <span class="{{ $service->stock>0 ? 'text-success' : 'text-danger' }}">
                                {{ $service->stock>0 ? $service->stock : 'Agotado' }}
                            </span>
                        </p>

                        <!-- Selector de cantidad -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad:</label>
                            <input type="number" class="form-control" id="quantity" min="1" max="{{ $service->stock }}" value="1">
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 mt-auto">
                            @if(Auth::check() && Auth::user()->id == $service->user_id)
                                <button class="btn btn-primary btn-lg" disabled>
                                    <i class="bi bi-cart-plus"></i> Eres el creador
                                </button>
                            @elseif(!Auth::check())
                                <button class="btn btn-warning btn-lg" disabled>
                                    <i class="bi bi-person"></i> Inicia sesión para comprar
                                </button>
                            @elseif($service->stock > 0)
                                <button class="btn btn-primary btn-lg" id="anhadir_button">
                                    <i class="bi bi-cart-plus"></i> Añadir al carrito
                                </button>
                            @else
                                <button class="btn btn-secondary btn-lg" disabled>
                                    <i class="bi bi-cart-x"></i> Sin stock
                                </button>
                            @endif
                            <button class="btn btn-secondary btn-lg">
                                <a href="/servicios"><i class="bi bi-arrow-left"></i> Seguir comprando</a>
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
                        <p class="card-text text-muted">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const carrito = @json(session('carrito', []));
    console.log(carrito);
    console.log(typeof carrito)
    Object.entries(carrito).forEach(([id, item]) => {
    console.log('Product ID:', id);
    console.log('Quantity:', item.quantity);
});
</script>


<script>
    
    $(document).ready(function () 
    {
        $('#anhadir_button').on('click', function()
        {
            $.ajax(
            {
                url: '/anhadir_servicio_carrito',
                type: 'POST',
                contentType: 'application/json',
                headers: 
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({ id: parseInt("{{$service->id}}")}),




                success: function (response) 
                {
                    console.log('Respuesta recibida', response);

                    if(response.exito)
                    {
                        text    = response.exito
                        bgColor = 'green'
                    }
                    else
                    {
                        text    = response.error
                        bgColor = 'red'
                    }



                    $('#messageBox')
                            .text(text) 
                            .css({
                                'background-color': `${bgColor}`,
                                'color': 'white',
                                'font-weight': 'bold',
                                'text-align': 'center',
                                'padding': '10px',
                                'width': '100%'
                            })
                            .show();

                        // Reload after 5 seconds
                        setTimeout(function() {
                            $('#messageBox').fadeOut('fast');
                        }, 1000);



                },
                error: function (xhr) {
                    console.error('Error actualizando carrito:', xhr.responseText);
                }
            });
        })
    });
</script>
@endsection

