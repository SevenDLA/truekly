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
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros y Búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.compras.listado') }}">
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
                                <li><a class="dropdown-item filter-btn" href="{{ route('admin.compras.listado', ['filter' => 'completed']) }}" data-filter="completed">Completado</a></li>
                                <li><a class="dropdown-item filter-btn" href="{{ route('admin.compras.listado', ['filter' => 'in_process']) }}" data-filter="in_process">En proceso</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item clear-filters" href="{{ route('admin.compras.listado') }}">Todos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="comprasTableContainer" class="table-responsive">
                    @if(!isset($is_ajax))
                    <!-- Tabla de Compras -->
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Compra</th>
                                <th>ID Servicio</th>
                                <th>Servicio</th>
                                <th>Comprado por</th>
                                <th>Vendido por</th>
                                <th>Precio (TokenSkills)</th>
                                <th>Fecha compra</th>
                                <th>Estado</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->id }}</td>
                                    <td>{{ $compra->service->id }}</td>
                                    <td>{{ $compra->service->title }}</td>
                                    <td>{{ $compra->buyer->username }}</td>
                                    <td>{{ $compra->seller->username }}</td>
                                    <td>{{ $compra->service->price }}</td>
                                    <td>{{ $compra->created_at }}</td>
                                    <td style="color: {{ $compra->status == 'P' ? 'orange' : 'green' }}">
                                        @if ($compra->status == 'P')
                                            {{ $ESTADO[$compra->status] }}
                                        @else
                                            COMPLETADO EL {{ $compra->updated_at }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No se encontraron compras</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endif
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3" id="paginationContainer">
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

    <script>
        let activeFilters = new Set();

        function applyFilters() {
            let searchValue = $('#searchInput').val();
            let filters = Array.from(activeFilters);

            $.ajax({
                url: '{{ route("admin.compras.listado") }}',
                type: 'GET',
                data: {
                    search: searchValue,
                    filter: filters
                },
                success: function(response) {
                    $('#comprasTableContainer').html(response.html);
                    $('#paginationContainer').html(response.pagination);
                    
                    // Actualizar el texto "Mostrando X a Y de Z registros"
                    let showingText = response.html.match(/Mostrando (\d+) a (\d+) de (\d+) registros/);
                    if (showingText) {
                        $('.showing-text').text(`Mostrando ${showingText[1]} a ${showingText[2]} de ${showingText[3]} registros`);
                    }
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
                    // Solo permitir un filtro a la vez para estado
                    activeFilters.clear();
                    $('.filter-btn').removeClass('active');
                    activeFilters.add(filter);
                    $(this).addClass('active');
                }

                applyFilters();
            });

            // Clear all filters
            $('.clear-filters').click(function(e) {
                e.preventDefault();
                activeFilters.clear();
                $('.filter-btn').removeClass('active');
                applyFilters();
            });

            // Handle search input
            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 500);
            });

            // Handle search button click
            $('#searchButton').click(function() {
                applyFilters();
            });

            // Handle pagination clicks
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $.ajax({
                    url: url,
                    data: {
                        search: $('#searchInput').val(),
                        filter: Array.from(activeFilters)
                    },
                    success: function(response) {
                        $('#comprasTableContainer').html(response.html);
                        $('#paginationContainer').html(response.pagination);
                    }
                });
            });
        });
    </script>
@endsection