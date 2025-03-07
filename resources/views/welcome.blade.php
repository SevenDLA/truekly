@extends('layout')

@section('title', 'Truekly')

@section('content')

    <section class="welcome-section p-5">
        <h1 class="text-center fs-1">Bienvenido a Truekly</h1>
    </section>

    <section class="funcion-section p-5 text-center">
        <h2 class="mb-5 fs-1">¿Cómo funciona nuestra página?</h2>
        <div class="container">
            <div class="row justify-content-center">
                @foreach (['Compra' => 'bi-cash-coin', 'Intercambia' => 'bi-arrow-left-right', 'Vende' => 'bi-piggy-bank'] as $titulo => $icono)
                    <div class="col-md-3">
                        <div class="icon-box mx-auto">
                            <i class="bi {{ $icono }} fs-1"></i>
                        </div>
                        <h5 class="fs-5">{{ $titulo }}</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <hr>

    <section class="categorias-section p-5 text-center">
        <h3 class="mb-4 fs-2">Categorías</h3>
        <div id="categoriasCarousel" class="carousel slide" data-bs-interval="false">

            <!-- Contenido del carrusel -->
            <div class="carousel-inner">
                @foreach (array_chunk(['Música', 'Gaming', 'Deporte', 'Arte', 'Cine', 'Tecnología'], 3) as $index => $grupo)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="container">
                            <div class="row justify-content-center">
                                @foreach ($grupo as $categoria)
                                    <div class="col-md-3">
                                        <div class="category-card mx-auto"><img src="{{ asset('images/computer.png') }}"></div>
                                        <h4 class="fs-5 mt-3">{{ $categoria }}</h4>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Flechas de navegación en los bordes -->
            <button class="carousel-control-prev position-absolute start-0 top-50 translate-middle-y text-black" 
                    type="button" 
                    data-bs-target="#categoriasCarousel" 
                    data-bs-slide="prev">
                <i class="bi bi-chevron-left fs-1"></i>
            </button>
            <button class="carousel-control-next position-absolute end-0 top-50 translate-middle-y text-black" 
                    type="button" 
                    data-bs-target="#categoriasCarousel" 
                    data-bs-slide="next">
                <i class="bi bi-chevron-right fs-1"></i>
            </button>

            <!-- Indicadores (puntitos del carrusel) -->
            <div class="carousel-indicators position-static mt-4">
                @foreach (array_chunk(['Música', 'Gaming', 'Deporte', 'Arte', 'Cine', 'Tecnología'], 3) as $index => $grupo)
                    <button type="button" 
                            data-bs-target="#categoriasCarousel" 
                            data-bs-slide-to="{{ $index }}" 
                            class="{{ $index == 0 ? 'active' : '' }} bg-black" 
                            aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>

        </div>
    </section>
    
    <section class="destacados-section p-5">
        <div>
            <h4 class="text-center mb-4 fs-2 text-black">Destacados</h4>
            <p class="text-center text-muted mb-5 fs-3">Elige de nuestros usuarios más populares</p>
            <div class="row text-black">
                @foreach ([
                    ['nombre' => 'Lucas Pérez', 'tag' => 'Popular', 'desc' => 'Diseño interfaces atractivas y responsivas con React y Tailwind.'],
                    ['nombre' => 'Ana Torres', 'tag' => 'Tendencia', 'desc' => 'Desarrollo backends seguros y escalables con Node.js y PostgreSQL.'],
                    ['nombre' => 'Martín Rojas', 'tag' => 'Mejor valorado', 'desc' => 'Construyo webs completas, desde el frontend hasta el backend.']
                ] as $usuario)
                    <div class="col-md-4">
                        <div class="profile-card bg-white p-3">
                            <span class="tag fs-4">
                                @if ($usuario['tag'] == 'Popular')
                                    &#11088; <!-- ⭐ -->
                                @elseif ($usuario['tag'] == 'Tendencia')
                                    &#128293; <!-- 🔥 -->
                                @elseif ($usuario['tag'] == 'Mejor valorado')
                                    &#127942; <!-- 🏆 -->
                                @endif
                                {{ $usuario['tag'] }}
                            </span>
                            <div class="profile-image text-center my-3">
                                <img src="{{ asset('images/computer.png') }}" 
                                    alt="Profile Image" class="img-fluid">
                            </div>
                            <p class="fs-5 fw-bold tag mb-2">{{ $usuario['nombre'] }}</p>
                            <p class="text-muted tag mb-3">{{ $usuario['desc'] }}</p>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-view">Ver perfil</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="token-section p-3"> <!-- Reducir el padding de la sección -->
    <div class="container"> <!-- Añadir un contenedor para limitar el ancho -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <!-- Título con estilo mejorado -->
                <h2 class="display-5 fw-bold text-white mb-4"> <!-- Título más grande y llamativo -->
                    ¿Consideras que no tienes habilidades?
                </h2>
                <!-- Párrafo con estilo mejorado -->
                <p class="lead text-secondary mb-4 text-white"> <!-- Texto más grande y suave -->
                    En nuestra plataforma, puedes adquirir <span class="text-primary fw-bold">TokenSkills</span>, nuestra moneda digital, para acceder a diversos servicios.
                    Si dispones de una cantidad significativa de tokens y habilidades, también tienes la opción de venderlos y recibir una compensación económica.
                </p>
                <!-- Botón de llamada a la acción (opcional) -->
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#tokensModal">
                    Ver paquetes de tokens
                </button>
            </div>
            <div class="col-md-6">
                <div id="tokensCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators position-static mt-3"> <!-- Reducir el margen superior -->
                        @foreach ([
                            ['tokens' => 100, 'precio' => 4.99],
                            ['tokens' => 250, 'precio' => 9.99],
                            ['tokens' => 500, 'precio' => 24.99],
                            ['tokens' => 1000, 'precio' => 45.99],
                            ['tokens' => 2000, 'precio' => 99.99]
                        ] as $index => $pack)
                            <button type="button" 
                                    data-bs-target="#tokensCarousel" 
                                    data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index == 0 ? 'active' : '' }} bg-black" 
                                    aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Carousel Inner -->
                    <div class="carousel-inner">
                        @foreach ([
                            ['tokens' => 100, 'precio' => 4.99],
                            ['tokens' => 250, 'precio' => 9.99],
                            ['tokens' => 500, 'precio' => 24.99],
                            ['tokens' => 1000, 'precio' => 45.99],
                            ['tokens' => 2000, 'precio' => 99.99]
                        ] as $index => $pack)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="d-flex justify-content-center">
                                    <div class="token-card p-3 text-center"> <!-- Centrar el contenido de la tarjeta -->
                                        <div class="d-flex justify-content-center align-items-center mb-3 position-relative" style="height: 150px;">
                                            <!-- Contenedor para las monedas -->
                                            <div class="position-relative" style="width: 100px; height: 100px;">
                                                @php
                                                    $numCoins = min(5, intval($pack['tokens'] / 100)); // Número de monedas (máximo 5)
                                                    $totalOffset = ($numCoins - 1) * 10; // Desplazamiento total hacia la derecha
                                                @endphp
                                                @for ($i = 0; $i < $numCoins; $i++)
                                                    <img src="{{ asset('images/coin.png') }}" 
                                                         alt="Coins" 
                                                         class="img-fluid position-absolute" 
                                                         style="
                                                            max-height: 100px;
                                                            transform: translateX({{ $i * 10 - ($totalOffset / 2) }}px);
                                                            z-index: {{ $i }};
                                                         ">
                                                @endfor
                                            </div>
                                        </div>
                                        <h5 class="text-black icon-box fs-5">{{ $pack['tokens'] }} TokenSkills</h5> <!-- Reducir el tamaño del texto -->
                                        <p class="fs-6 mb-2 text-black icon-box">{{ $pack['precio'] }}€</p> <!-- Reducir el tamaño del texto -->
                                        <a href="/buy/{{ $pack['tokens'] }}/{{ $pack['precio'] }}" class="btn btn-subscribe btn-sm w-100">Comprar</a> <!-- Reducir el tamaño del botón -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#tokensCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#tokensCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="tokensModal" tabindex="-1" aria-labelledby="tokensModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Modal grande -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="tokensModalLabel">Paquetes de TokenSkills</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-nowrap overflow-auto"> <!-- Contenedor flexible en una sola fila -->
                    @foreach ([
                        ['tokens' => 100, 'precio' => 4.99],
                        ['tokens' => 250, 'precio' => 9.99],
                        ['tokens' => 500, 'precio' => 24.99],
                        ['tokens' => 1000, 'precio' => 45.99],
                        ['tokens' => 2000, 'precio' => 99.99]
                    ] as $pack)
                        <div class="flex-shrink-0 me-3" style="width: 250px;"> <!-- Ancho fijo para cada tarjeta -->
                            <div class="token-card p-3 text-center bg-light rounded shadow-sm position-relative">
                                <div class="d-flex justify-content-center align-items-center mb-3 position-relative" style="height: 100px;">
                                    <!-- Contenedor para las monedas -->
                                    <div class="position-relative" style="width: 100px; height: 100px;">
                                        @php
                                            $numCoins = min(5, intval($pack['tokens'] / 100)); // Número de monedas (máximo 5)
                                            $totalOffset = ($numCoins - 1) * 10; // Desplazamiento total hacia la derecha
                                        @endphp
                                        @for ($i = 0; $i < $numCoins; $i++)
                                            <img src="{{ asset('images/coin.png') }}" 
                                                 alt="Coins" 
                                                 class="img-fluid position-absolute" 
                                                 style="
                                                    max-height: 100px;
                                                    transform: translateX({{ $i * 10 - ($totalOffset / 2) }}px);
                                                    z-index: {{ $i }};
                                                 ">
                                        @endfor
                                    </div>
                                </div>
                                <h5 class="text-black fs-5">{{ $pack['tokens'] }} TokenSkills</h5>
                                <p class="fs-6 mb-2 text-black">{{ $pack['precio'] }}€</p>
                                <a href="/buy/{{ $pack['tokens'] }}/{{ $pack['precio'] }}" class="btn btn-primary btn-sm w-100">Comprar</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection
