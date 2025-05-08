@extends('layout')

@section('title', 'Marketplace')

@section('content')
<section class="py-5" style="min-height: calc(100vh - 200px);">
    <div class="container h-100">
        <div class="row h-100">
            <!-- Lista de Ofertas -->
            <div class="col-12">
                <div class="row" id="offers-list">
                    @foreach ($ofertas as $oferta)
                        @if($oferta->status == 'E')
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 shadow-sm hover-shadow">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">{{ $oferta->tokens }} Tokens</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-4">
                                            <li class="mb-2">
                                                <i class="bi bi-currency-euro me-2 text-primary"></i>
                                                <strong>Precio:</strong> {{ $oferta->price }} €
                                            </li>
                                            <li class="mb-2">
                                                <i class="bi bi-person-circle me-2 text-primary"></i>
                                                <strong>Vendedor:</strong> {{ $oferta->seller->username }}
                                            </li>
                                            <li>
                                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                                <strong>Estado:</strong> <span class="badge bg-success">{{ $ESTADO[$oferta->status] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-white border-top-0 text-center">
                                        <a class="btn btn-primary btn-lg w-100" href="/comprar/{{ $oferta->tokens }}/{{ $oferta->price }}/{{ $oferta->seller->id }}/{{ $oferta->id }}">
                                            <i class="bi bi-cart-plus me-2"></i>Comprar tokens
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection