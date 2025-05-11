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
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros y Búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('users.listado') }}">
                            <div class="input-group">
                                <input type="text" id="search-input" name="search" class="form-control"
                                    placeholder="Buscar usuarios..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filtros
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item filter-btn"
                                        href="{{ route('users.listado', ['filter' => 'with_tokens']) }}"
                                        data-filter="with_tokens">Con TokenSkills</a></li>
                                <li><a class="dropdown-item filter-btn"
                                        href="{{ route('users.listado', ['filter' => 'without_tokens']) }}"
                                        data-filter="without_tokens">Sin TokenSkills</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('users.listado') }}">Todos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Usuarios -->
                <div class="table-responsive" id="users-table-container">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>TokenSkills</th>
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
                                            <a href="{{ route('users.mostrar', $user->id) }}" class="btn btn-sm btn-info"
                                                title="Ver">
                                                <i class="bi bi-search"></i>
                                            </a>
                                            <a href="{{ route('users.actualizar', $user->id) }}"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('users.eliminar', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Estás seguro?')">
                                                    <i class="bi bi-trash"></i>
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
                <div class="d-flex justify-content-between align-items-center mt-3" id="pagination-container">
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

    <script>
        let activeFilters = new Set();

        function applyFilters() {
            let searchValue = $('#search-input').val();
            let filters = Array.from(activeFilters);

            $.ajax({
                url: '{{ route("users.listado") }}',
                type: 'GET',
                data: {
                    search: searchValue,
                    filter: filters
                },
                success: function(response) {
                    $('#users-table-container').html(response.html);
                    $('#pagination-container').html(response.pagination);
                }
            });
        }

        $(document).ready(function() {
            // Handle filter clicks
            $('.filter-btn').click(function() {
                let filter = $(this).data('filter');

                if (activeFilters.has(filter)) {
                    activeFilters.delete(filter);
                    $(this).removeClass('active');
                } else {
                    activeFilters.add(filter);
                    $(this).addClass('active');
                }

                applyFilters();
            });

            // Handle search input
            let searchTimeout;
            $('#search-input').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 300);
            });

            // Handle pagination clicks
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $.ajax({
                    url: url,
                    data: {
                        search: $('#search-input').val(),
                        filter: Array.from(activeFilters)
                    },
                    success: function(response) {
                        $('#users-table-container').html(response.html);
                        $('#pagination-container').html(response.pagination);
                    }
                });
            });
        });
    </script>
@endsection
