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
        
        <div class="card shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column">
                <h5 class="card-title text-primary">{{ $service->title }}</h5>
                <div class="text-center p-3">
                    <img src="{{ asset('images/default.jpg') }}" alt="Imagen del servicio"
                        class="mx-auto d-block img-fluid" style="width: 100%; height: 200px; object-fit: cover; border-radius: var(--border-radius-md);">
                </div>
                <p class="card-text text-muted flex-grow-1">{{ Str::limit($service->description, 80) }}</p>
                <h6 class="text-success">Precio: ${{ $service->price }}</h6>
                <small class="text-secondary">Publicado por: {{ $service->user->name }} {{ $service->user->surname }}</small>
                <div class="mt-3">
                    <a href="/servicio/ver/{{ $service->id }}" class="btn btn-primary btn-sm">Ver más</a>
                </div>
            </div>
            <div class="card-footer bg-light text-center">
                @if(Auth::check() && Auth::user()->id == $service->user_id)
                    <a href="/servicio/editar/{{ $service->id }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>
                    <a href="/servicio/eliminar/{{ $service->id }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endif

<!-- Paginador mejorado -->
@if ($services->hasPages())
<div class="col-12 mt-4">
    <div class="pagination-links d-flex justify-content-center flex-wrap" style="gap: 5px;">
        <ul class="pagination">
            {{-- Botón Anterior --}}
            @if ($services->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius: var(--border-radius-md);">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $services->previousPageUrl() }}" rel="prev" style="border-radius: var(--border-radius-md);">&laquo;</a>
                </li>
            @endif

            {{-- Números de página --}}
            @php
                $start = max($services->currentPage() - 2, 1);
                $end = min($start + 4, $services->lastPage());
                $start = max(min($end - 4, $start), 1);
            @endphp

            @if($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $services->url(1) }}" style="border-radius: var(--border-radius-md);">1</a>
                </li>
                @if($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link" style="border-radius: var(--border-radius-md);">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $services->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $services->url($i) }}" style="border-radius: var(--border-radius-md);">{{ $i }}</a>
                </li>
            @endfor

            @if($end < $services->lastPage())
                @if($end < $services->lastPage() - 1)
                    <li class="page-item disabled">
                        <span class="page-link" style="border-radius: var(--border-radius-md);">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $services->url($services->lastPage()) }}" style="border-radius: var(--border-radius-md);">{{ $services->lastPage() }}</a>
                </li>
            @endif

            {{-- Botón Siguiente --}}
            @if ($services->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $services->nextPageUrl() }}" rel="next" style="border-radius: var(--border-radius-md);">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" style="border-radius: var(--border-radius-md);">&raquo;</span>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif