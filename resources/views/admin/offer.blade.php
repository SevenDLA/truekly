@extends('dashboard')

@section('title', 'Gestión de Ofertas')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Gestión de Ofertas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Ofertas</li>
        </ol>

        <!-- Card de Contenido -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-tags me-1"></i>
                        Listado de Ofertas
                    </div>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Nueva Oferta
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros y Búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar ofertas...">
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filtros
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Activas</a></li>
                                <li><a class="dropdown-item" href="#">Inactivas</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Todas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Ofertas -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Vendedor</th>
                                <th>Tokens</th>
                                <th>Precio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ofertas as $oferta)
                                <tr>
                                    <td>{{ $oferta->id }}</td>
                                    <td>{{ $oferta->seller->username }}</td>
                                    <td>{{ $oferta->tokens }}</td>
                                    <td>{{ $oferta->price }} €</td>
                                    <td style="color: {{ $oferta->status == 'T' ? 'black' : 'green' }}">
                                        {{ $ESTADO[$oferta->status] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron ofertas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="showing-text">
                        Mostrando {{ $ofertas->firstItem() }} a {{ $ofertas->lastItem() }} de {{ $ofertas->total() }} registros
                    </div>
                    <div class="pagination-custom">
                        {{ $ofertas->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
