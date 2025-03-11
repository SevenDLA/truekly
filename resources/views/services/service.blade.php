@extends('layout')

@section('title', 'Listado de Servicios')

@section('content')
<section class="bg-white py-5">
    <div class="container">
        <div class="row">
            <!-- Filtros en la izquierda -->
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Filtrar Servicios</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="filtersAccordion">
                            <!-- Filtro por precio -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterPrice">
                                        <i class="bi bi-currency-dollar me-2"></i> Precio
                                    </button>
                                </h2>
                                <div id="filterPrice" class="accordion-collapse collapse show" data-bs-parent="#filtersAccordion">
                                    <div class="accordion-body">
                                        <label for="priceRange" class="form-label">Máximo: 
                                            <span id="priceValue">{{ $maxPrice && $maxPrice > 0 ? $maxPrice : 'Cualquiera' }}</span>
                                        </label>
                                        <input type="range" class="form-range" min="0" max="1000" step="10" id="priceRange" 
                                               value="{{ $maxPrice && $maxPrice > 0 ? $maxPrice : 0 }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro por categoría -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCategory">
                                        <i class="bi bi-tags me-2"></i> Categoría
                                    </button>
                                </h2>
                                <div id="filterCategory" class="accordion-collapse collapse" data-bs-parent="#filtersAccordion">
                                    <div class="accordion-body">
                                        @foreach(['Tecnología', 'Hogar', 'Educación', 'Salud'] as $category)
                                        <div class="form-check">
                                            <input class="form-check-input category-filter" type="checkbox" value="{{ $category }}"
                                                   {{ in_array($category, $categories ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $category }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro por usuario -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterUser">
                                        <i class="bi bi-person me-2"></i> Usuario
                                    </button>
                                </h2>
                                <div id="filterUser" class="accordion-collapse collapse" data-bs-parent="#filtersAccordion">
                                    <div class="accordion-body">
                                        <select id="userFilter" class="form-select">
                                            <option value="">Todos los usuarios</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $userFilter == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} {{ $user->surname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de servicios a la derecha -->
            <div class="col-md-9">
                <div class="row" id="service-list">
                    @include('services.partials.service_list', ['services' => $services])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Actualizar el valor del precio en tiempo real
    document.getElementById("priceRange").addEventListener("input", function () {
        let priceValue = this.value == 0 ? 'Cualquiera' : this.value;
        document.getElementById("priceValue").innerText = priceValue;
        applyFilters(); // Aplicar filtros automáticamente
    });

    // Aplicar filtros automáticamente cuando cambian los checkboxes de categoría
    document.querySelectorAll('.category-filter').forEach(checkbox => {
        checkbox.addEventListener("change", applyFilters);
    });

    // Aplicar filtros automáticamente cuando se selecciona un usuario
    document.getElementById("userFilter").addEventListener("change", applyFilters);

    // Función para aplicar los filtros
    function applyFilters() {
        let maxPrice = document.getElementById("priceRange").value;
        let selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
        let userFilter = document.getElementById("userFilter").value;

        // Construir la URL con los filtros
        let url = `/services?maxPrice=${maxPrice}&categories=${selectedCategories.join(',')}&user=${userFilter}`;

        // Actualizar la URL sin recargar la página
        history.pushState(null, null, url);

        // Enviar la solicitud AJAX
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indicar que es una solicitud AJAX
            }
        })
        .then(response => response.text())
        .then(html => {
            // Actualizar la lista de servicios y el paginador
            document.getElementById("service-list").innerHTML = html;
            document.getElementById("pagination-links").innerHTML = html.includes('pagination') ? html : '';
        });
    }

    // Manejar el evento de retroceso/avance del navegador
    window.addEventListener("popstate", function () {
        applyFilters(); // Aplicar filtros cuando el usuario navega hacia atrás/adelante
    });
</script>
@endsection