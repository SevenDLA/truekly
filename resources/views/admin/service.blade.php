@extends('dashboard')

@section('title', 'Gestión de Servicios')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Servicios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Servicios</li>
    </ol>

    <!-- Card de Contenido -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-cogs me-1"></i>
                    Listado de Servicios
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Filtros y Búsqueda -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('services.admin.listado') }}">
                        <div class="input-group">
                            <input type="text" id="search-input" name="search" class="form-control" 
                                   placeholder="Buscar servicios..." value="{{ request('search') }}">
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
                                  href="{{ route('services.admin.listado', ['filter' => 'high_price']) }}"
                                  data-filter="high_price">Precio Alto (>50)</a></li>
                            <li><a class="dropdown-item filter-btn" 
                                  href="{{ route('services.admin.listado', ['filter' => 'low_price']) }}"
                                  data-filter="low_price">Precio Bajo (<50)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('services.admin.listado') }}">Todos</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tabla de Servicios -->
            <div class="table-responsive" id="services-table-container">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Creador</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio (TokenSkills)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->title}}
                            <td>{{ $service->user->username }}</td>
                            <td>{{ Str::limit($service->description, 50) }}</td>
                            <td>{{ $CATEGORY[$service->category]}}</td>
                            <td>{{ number_format($service->price, 2) }}</td>
                            
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.services.mostrar', $service->id) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.services.actualizar', $service->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.service.eliminar', $service->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este servicio?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron servicios</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-3" id="pagination-container">
                <div class="showing-text">
                    Mostrando {{ $services->firstItem() }} a {{ $services->lastItem() }} de {{ $services->total() }} registros
                </div>
                <div class="pagination-custom">
                    {{ $services->appends(request()->query())->links() }}
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
            url: '{{ route("services.admin.listado") }}',
            type: 'GET',
            data: {
                search: searchValue,
                filter: filters
            },
            success: function(response) {
                $('#services-table-container').html(response.html);
                $('#pagination-container').html(response.pagination);
            }
        });
    }

    $(document).ready(function() {
        // Handle filter clicks
        $('.filter-btn').click(function(e) {
            e.preventDefault();
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
                    $('#services-table-container').html(response.html);
                    $('#pagination-container').html(response.pagination);
                }
            });
        });
    });
</script>

<style>
    .table th {
        white-space: nowrap;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85em;
    }
    .pagination-custom .pagination {
        margin: 0;
    }
</style>
@endsection