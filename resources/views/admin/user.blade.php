@extends('dashboard')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    <!-- Card de Contenido -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    Listado de Usuarios
                </div>
                <a href="{{ route('users.alta') }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filtros y Búsqueda -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('users.listado') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar usuarios..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-1"></i> Filtros
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('users.listado', ['filter' => 'with_tokens']) }}">Con Tokens</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.listado', ['filter' => 'without_tokens']) }}">Sin Tokens</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('users.listado') }}">Todos</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Tokens</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->tokens > 0 ? 'success' : 'secondary' }}">
                                    {{ $user->tokens }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('users.mostrar', $user->id) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.actualizar', $user->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.eliminar', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No se encontraron usuarios</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="showing-text">
                    Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} registros
                </div>
                <div class="pagination-custom">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    .table th {
        white-space: nowrap;
    }
    .table td {
        vertical-align: middle;
    }
    .pagination-custom .pagination {
        justify-content: flex-end;
        margin: 0;
    }
    .showing-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .badge {
        font-size: 0.85em;
        font-weight: 500;
        min-width: 40px;
        display: inline-block;
        text-align: center;
    }
    .btn-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection