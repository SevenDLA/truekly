@extends('dashboard')

@section('title', 'Gestión de Compras')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Gestión de Compras</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Compras</li>
        </ol>

        <!-- Card de Contenido -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-compras me-1"></i>
                        Listado de Compras
                    </div>
                    <a href="#" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Nuevo Compra
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros y Búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar compras...">
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
                                <li><a class="dropdown-item" href="#">Con Tokens</a></li>
                                <li><a class="dropdown-item" href="#">Sin Tokens</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Todos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Compras -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Servicio</th>
                                <th>Comprado por</th>
                                <th>Vendido por</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                        
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->id }}</td>
                                    <td>{{ $compra->service->title }}</td>
                                    <td>{{ $compra->buyer->username }}</td>
                                    <td>{{ $compra->seller->username }}</td>
                                    <td>{{ $compra->service->price }} tokens</td>
                  
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-info" title="Ver">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No se encontraron compras</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="showing-text">
                        Mostrando {{ $compras->firstItem() }} a {{ $compras->lastItem() }} de {{ $compras->total() }} registros
                    </div>
                    <div class="pagination-custom">
                        {{ $compras->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
