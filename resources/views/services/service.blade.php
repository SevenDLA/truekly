@extends('layout')

@section('title', 'Listado de Servicios')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Filtros en la izquierda -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Filtrar Servicios</h5>
                </div>
                <div class="card-body">
                    <!-- Acordeón de filtros -->
                    <div class="accordion" id="filtersAccordion">
                        
                        <!-- Filtro por precio -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterPrice">
                                    Precio
                                </button>
                            </h2>
                            <div id="filterPrice" class="accordion-collapse collapse show" data-bs-parent="#filtersAccordion">
                                <div class="accordion-body">
                                    <label for="priceRange" class="form-label">Máximo: <span id="priceValue">100</span>€</label>
                                    <input type="range" class="form-range" min="0" max="999999999999" step="10" id="priceRange" value="100">
                                </div>
                            </div>
                        </div>

                        <!-- Filtro por categoría -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterCategory">
                                    Categoría
                                </button>
                            </h2>
                            <div id="filterCategory" class="accordion-collapse collapse" data-bs-parent="#filtersAccordion">
                                <div class="accordion-body">
                                    @foreach(['Tecnología', 'Hogar', 'Educación', 'Salud'] as $category)
                                    <div class="form-check">
                                        <input class="form-check-input category-filter" type="checkbox" value="{{ $category }}">
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
                                    Usuario
                                </button>
                            </h2>
                            <div id="filterUser" class="accordion-collapse collapse" data-bs-parent="#filtersAccordion">
                                <div class="accordion-body">
                                    <input type="text" id="userFilter" class="form-control" placeholder="Buscar usuario...">
                                </div>
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-primary w-100 mt-3" onclick="applyFilters()">Aplicar filtros</button>
                </div>
            </div>
        </div>

        <!-- Lista de servicios a la derecha -->
        <div class="col-md-9">
            <div class="row" id="service-list">
                @foreach ($services as $service)
                <div id="SERVICE{{ $service->id }}" class="col-md-4 col-sm-6 mb-4 service-item"
                    data-price="{{ $service->price }}"
                    data-category="{{ $service->category }}"
                    data-user="{{ $service->user->name }} {{ $service->user->surname }}">
                    
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">{{ $service->title }}</h5>

                            <!-- Imagen fija -->
                            <div class="text-center p-3">
                                <img src="{{ asset('images/default.jpg') }}" alt="Imagen del servicio"
                                    class="mx-auto d-block img-fluid" style="width: 100%; height: 200px; object-fit: cover;">
                            </div>

                            <p class="card-text text-muted">{{ Str::limit($service->description, 80) }}</p>
                            <h6 class="text-success">Precio: ${{ $service->price }}</h6>
                            <small class="text-secondary">Publicado por: {{ $service->user->name }} {{ $service->user->surname }}</small>

                            <div class="mt-3">
                                <a href="/service/{{ $service->id }}" class="btn btn-primary btn-sm">Ver más</a>
                            </div>
                        </div>

                        <div class="card-footer bg-light text-center">
                            <a href="/service/editar/{{ $service->id }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>
                            <a href="/service/eliminar/{{ $service->id }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById("priceRange").addEventListener("input", function () {
        document.getElementById("priceValue").innerText = this.value;
    });

    function applyFilters() {
        let maxPrice = document.getElementById("priceRange").value;
        let selectedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value.toLowerCase());
        let userFilter = document.getElementById("userFilter").value.toLowerCase();

        let services = document.getElementsByClassName("service-item");

        for (let service of services) {
            let servicePrice = parseInt(service.getAttribute("data-price"));
            let serviceCategory = service.getAttribute("data-category").toLowerCase();
            let serviceUser = service.getAttribute("data-user").toLowerCase();

            let matchesPrice = servicePrice <= maxPrice;
            let matchesCategory = selectedCategories.length === 0 || selectedCategories.includes(serviceCategory);
            let matchesUser = userFilter === "" || serviceUser.includes(userFilter);

            if (matchesPrice && matchesCategory && matchesUser) {
                service.style.display = "";
            } else {
                service.style.display = "none";
            }
        }
    }
</script>
@endsection
