@extends('layout')

@section('title', 'Carrito')

@section('content')
@php
    use App\Models\Service;
    $carrito = session('carrito', []);
@endphp

<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart me-1"></i> Mi Carrito</h2>
    <div class="row">
        <!-- Product List -->
        <div class="col-md-8" id="listadoCarro">
            <script>
                var listado_productos = [];
            </script>
            @php
                $precio_total = 0;
            @endphp

            @forelse ($carrito as $id => $precio)
                @php
                    $servicio = Service::find($id);
                @endphp

                <script>
                    listado_productos.push(@json($servicio))
                </script>

                @if($servicio)

                    @php
                        $precio_total += $servicio->price;
                    @endphp

                    <div class="card mb-4 position-relative servicioEnCarro">
                        <!-- Delete Button -->
                        <button class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute top-0 end-0 m-2 delete-button" style="width: 30px; height: 30px;" data-id="{{ $servicio->id }}">
                            <i class="bi bi-x-lg"></i>
                        </button>

                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 text-center p-2">
                                <img src="https://via.placeholder.com/80" class="img-fluid rounded" alt="Service Image">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title mb-1">{{ $servicio->title }}</h5>
                                    <p class="text-muted mb-2">{{ $servicio->description }}</p>
                                    <small class="text-secondary">ID: {{ $servicio->id }}</small>
                                </div>
                            </div>
                            <div class="col-md-3 text-end pe-3">
                                <p class="mb-1 fw-bold">{{ $servicio->price }} tokens</p>
                                <select class="form-select form-select-sm w-auto d-inline-block">
                                    <option selected>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                
                
                @else
                    <p class="text-danger">Servicio con ID {{ $id }} no encontrado.</p>
                @endif
            @empty
                <p>Tu carrito está vacío.</p>
            @endforelse
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">Resumen del Pedido</h5>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span id="precioTotal">{{ $precio_total }} tokens</span>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Descuento</span>
                    <span>- 0</span>
                </div>
                
                <hr>

                <button class="btn btn-primary w-100 mt-2 pay-button">Proceder al Pago</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function()
    {

        $('.delete-button').on('click', function() 
        {
            let card = $(this).closest('.card');
            console.log("clicked")
            $.ajax(
            {
                url:'/quitar_servicio_carrito',
                type:'POST',
                contentType: 'application/json',
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                
                data: JSON.stringify({ id: parseInt(this.dataset.id)}),


                success: function (response)
                {
                    console.log(response)
                    listado_productos.forEach(p => console.log('ID:', p.id, typeof p.id));
                    let precioActual = parseFloat($('#precioTotal').html());

                    let producto = listado_productos.find(p => p.id === response.id_servicio);
                    let index = listado_productos.findIndex(p => p.id === response.id_servicio);
                    listado_productos.splice(index, 1);
                    console.log('Producto:', producto);

                    $('#precioTotal').html(precioActual - producto.price)
                    card.remove();

                    if ($('.servicioEnCarro').length === 0) 
                    {
                        console.log('No elements found');
                        $('#listadoCarro').prepend('<p>Tu carrito está vacío.</p>')
                    }
                },

                error: function (xhr) {
                    console.error('Error borrando carrito:', xhr.responseText);
                }

            });

        });

        $('.pay-button').on('click', function()
        {

            console.log(listado_productos)
            console.log(typeof(listado_productos))

            listado_productos.forEach((producto, index) => 
            {
                console.log("User seller: " + producto.user_id);
                console.log("Price: " + producto.price);
            });

            $.ajax(
            {
                url: '/carrito/nuevo',      // The URL where you want to send the request
                type: 'POST',               // The HTTP request type
                data: JSON.stringify(
                {      // The data to send, stringify the object
                    productos: listado_productos
                }),
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',  // Ensure the server knows it's JSON
                success: function(response) {  // Success callback
                    console.log('Success:', response);  // Handle success here
                },
                error: function(xhr, status, error) {  // Error callback
                    console.error('Error:', error);  // Handle errors here
                }
            });


        }) 

    })
</script>
@endsection
