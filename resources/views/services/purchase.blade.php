@extends('layout')

@section('title', $service->title)

@section('content')
<!-- Sección principal con fondo blanco -->
<section class="bg-white py-4">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                <li class="breadcrumb-item"><a href="/services">Servicios</a></li>
                <li class="breadcrumb-item active underline" aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
        <div class="row align-items-stretch">
            <!-- Imagen del servicio -->
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <img src="{{ asset($service->image ?? 'images/default.jpg') }}" 
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
                        <h4 class="text-success">Precio: ${{ number_format($service->price, 2) }}</h4>
                        <p class="text-secondary">Disponible: 
                            <span class="{{ $service->available ? 'text-success' : 'text-danger' }}">
                                {{ $service->available ? 'En stock' : 'Agotado' }}
                            </span>
                        </p>

                        <!-- Selector de cantidad -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad:</label>
                            <input type="number" class="form-control" id="quantity" min="1" max="10" value="1">
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 mt-auto">
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
                        <p class="card-text text-muted">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
