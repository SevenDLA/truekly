@extends('layout')

@section('title', 'Listado de Servicios')

@section('content')
<section class="py-5" style="min-height: calc(100vh - 200px);">
    <div class="container h-100">
        <div class="row h-100">
            <!-- Filtros (visible en todas las pantallas) -->
            <div class="col-12 mb-4">
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Filtrar Servicios</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="accordion" id="filtersAccordion">
                            <!-- Filtro por Precio -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterPrice">
                                        <i class="bi bi-currency-dollar me-2"></i> TokenSkills
                                    </button>
                                </h2>
                                <div id="filterPrice" class="accordion-collapse collapse show" data-bs-parent="#filtersAccordion">
                                    <div class="accordion-body">
                                        <label for="priceRange" class="form-label">
                                            Máximo: <span id="priceValue">{{ $maxPrice > 0 ? $maxPrice : 'Cualquiera' }}</span>
                                        </label>
                                        <input type="range" class="form-range" min="0" max="1000" step="10" id="priceRange" 
                                               value="{{ $maxPrice > 0 ? $maxPrice : 0 }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro por Categoría -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCategory">
                                        <i class="bi bi-tags me-2"></i> Categoría
                                    </button>
                                </h2>
                                <div id="filterCategory" class="accordion-collapse collapse" data-bs-parent="#filtersAccordion">
                                    <div class="accordion-body">
                                        @foreach(\App\Models\Service::CATEGORY as $key => $category)
                                            <div class="form-check">
                                                <input class="form-check-input category-filter" type="checkbox" value="{{ $key }}" 
                                                       {{ in_array($category, $categories ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $category }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Filtro por Usuario -->
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
                                                    {{ $user->username }}
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

            <!-- Lista de Servicios (ocupa todo el ancho) -->
            <div class="col-12">
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
    document.addEventListener("DOMContentLoaded", function () {
        const priceRange = document.getElementById("priceRange");
        const priceValue = document.getElementById("priceValue");
        const categoryFilters = document.querySelectorAll('.category-filter');
        const userFilter = document.getElementById("userFilter");

        function applyFilters() {
            const maxPrice = priceRange.value;
            const selectedCategories = Array.from(categoryFilters)
                .filter(cb => cb.checked)
                .map(cb => cb.value)
                .filter(val => val); // Eliminar valores vacíos

            const user = userFilter.value;
            
            // Solo incluir categorías si hay alguna seleccionada
            const categoriesParam = selectedCategories.length > 0 ? selectedCategories.join(',') : '';
            
            const url = `/servicios?maxPrice=${maxPrice}${categoriesParam ? '&categories=' + categoriesParam : ''}${user ? '&user=' + user : ''}`;

            history.pushState(null, null, url);

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.text())
                .then(html => {
                    document.getElementById("service-list").innerHTML = html;
                });
        }

        priceRange.addEventListener("input", function () {
            priceValue.innerText = this.value == 0 ? 'Cualquiera' : this.value;
            applyFilters();
        });

        categoryFilters.forEach(checkbox => checkbox.addEventListener("change", applyFilters));
        userFilter.addEventListener("change", applyFilters);

        window.addEventListener("popstate", applyFilters);
    });
</script>
@endsection