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
        <div class="col-md-8">
            <script>
                var listado_productos = [];
            </script>
            @php
                $precio_total = 0;
            @endphp

            @forelse ($carrito as $id)
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

                    <div class="card mb-4 position-relative">
                        <!-- Delete Button -->
                        <button class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute top-0 end-0 m-2" style="width: 30px; height: 30px;">
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
                    <span>{{ $precio_total }}</span>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Descuento</span>
                    <span>- 0</span>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Impuestos</span>
                    <span>TBD</span>
                </div>
                <hr>

                <button class="btn btn-primary w-100 mt-2">Proceder al Pago</button>
            </div>
        </div>
    </div>
</div>

<script>
    console.log(listado_productos)
</script>
@endsection
