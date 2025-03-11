@if ($services->isEmpty())
    <!-- Caja de "No hay resultados" -->
    <div class="col-12">
        <div class="card shadow-sm text-center p-4 mb-4 bg-light border-0">
            <div class="card-body">
                <h4 class="card-title text-muted mb-3">
                    <i class="bi bi-search display-4"></i> <!-- Icono de búsqueda -->
                </h4>
                <h4 class="text-muted mb-3">No se encontraron resultados</h4>
                <p class="text-muted mb-0">Intenta ajustar los filtros para encontrar lo que buscas.</p>
            </div>
        </div>
    </div>
@else
    <!-- Lista de servicios -->
    @foreach ($services as $service)
    <div id="SERVICE{{ $service->id }}" class="col-md-4 col-sm-6 mb-4 service-item"
        data-price="{{ $service->price }}"
        data-category="{{ $service->category }}"
        data-user="{{ $service->user->name }} {{ $service->user->surname }}">
        
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h5 class="card-title text-primary">{{ $service->title }}</h5>
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
@endif

<!-- Paginador -->
@if ($services->hasPages())
<div class="pagination-links">
    {{ $services->appends([
        'maxPrice' => request('maxPrice'),
        'categories' => request('categories'),
        'user' => request('user'),
    ])->links() }}
</div>
@endif