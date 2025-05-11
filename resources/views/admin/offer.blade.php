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
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros y Búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.offers.listado') }}">
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
                                <li><a class="dropdown-item filter-btn" href="{{ route('admin.offers.listado', ['filter' => 'sold']) }}" data-filter="sold">Vendido</a></li>
                                <li><a class="dropdown-item filter-btn" href="{{ route('admin.offers.listado', ['filter' => 'on_sale']) }}" data-filter="on_sale">En venta</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item clear-filters" href="{{ route('admin.offers.listado') }}">Todas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="ofertasTableContainer" class="table-responsive">
                    @if(!isset($is_ajax))
                    <!-- Tabla de Ofertas -->
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Vendedor</th>
                                <th>TokenSkills</th>
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
                                    <td style="color: {{ $oferta->status == 'E' ? 'green' : 'black' }}">
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
                    @endif
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3" id="paginationContainer">
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

    <script>
        let activeFilters = new Set();

        function applyFilters() {
            let searchValue = $('#searchInput').val();
            let filters = Array.from(activeFilters);

            $.ajax({
                url: '{{ route("admin.offers.listado") }}',
                type: 'GET',
                data: {
                    search: searchValue,
                    filter: filters
                },
                success: function(response) {
                    $('#ofertasTableContainer').html(response.html);
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
                        $('#ofertasTableContainer').html(response.html);
                        $('#paginationContainer').html(response.pagination);
                    }
                });
            });
        });
    </script>
@endsection