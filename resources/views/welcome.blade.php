@extends('layout')

@section('title', 'Truekly - Plataforma de intercambio de habilidades')

@section('content')
    <!-- Hero Section -->
    <section class="welcome-section">
        <div class="container">
            <h1 class="animate-fadeInUp text-center">Bienvenido a Truekly</h1>
            <p class="lead text-white mt-4 animate-fadeInUp animate-delay-1 text-center" style="max-width: 700px; margin: 0 auto;">
                La plataforma donde puedes comprar, vender e intercambiar habilidades y servicios con otros usuarios.
            </p>
            <div class="mt-4 animate-fadeInUp animate-delay-2 text-center">
                <a href="#como-funciona" class="btn btn-primary">Descubre cómo funciona</a>
            </div>
        </div>
    </section>
    <!-- How It Works Section -->
    <section id="como-funciona" class="funcion-section">
        <div class="container">
            <h2 class="text-center fs-1 mb-5">¿Cómo funciona nuestra plataforma?</h2>
            <div class="row justify-content-center g-4">
                @foreach ([
                    ['titulo' => 'Compra', 'icono' => 'bi-cash-coin', 'desc' => 'Adquiere habilidades y servicios de otros usuarios utilizando nuestros TokenSkills.'],
                    ['titulo' => 'Intercambia', 'icono' => 'bi-arrow-left-right', 'desc' => 'Ofrece tus habilidades a cambio de otras sin necesidad de usar dinero.'],
                    ['titulo' => 'Vende', 'icono' => 'bi-piggy-bank', 'desc' => 'Monetiza tus conocimientos y habilidades ofreciéndolos en nuestra plataforma.']
                ] as $index => $item)
                    <div class="col-md-4 col-lg-3">
                        <div class="icon-box h-100 text-center" style="--animation-order: {{ $index }}">
                            <i class="bi {{ $item['icono'] }} fs-1"></i>
                            <h5 class="fs-5 mt-3">{{ $item['titulo'] }}</h5>
                            <p class="text-muted mt-2">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    
    <!-- Categories Section -->
    <section class="categorias-section py-5" id="categoriasCarousel">
        <hr class="py-5 border-primary">
        <div class="container">
            <h3 class="text-center fs-2">Explora por Categorías</h3>
            <div class="carousel slide" data-bs-interval="false">
                <!-- Carousel Inner -->
                <div class="carousel-inner">
                    @foreach (array_chunk([
                        ['nombre' => 'Música', 'icono' => 'music-note'],
                        ['nombre' => 'Gaming', 'icono' => 'controller'],
                        ['nombre' => 'Deporte', 'icono' => 'activity'],
                        ['nombre' => 'Arte', 'icono' => 'palette'],
                        ['nombre' => 'Cine', 'icono' => 'film'],
                        ['nombre' => 'Tecnología', 'icono' => 'cpu']
                    ], 3) as $index => $grupo)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row justify-content-center">
                                @foreach ($grupo as $categoria)
                                    <div class="col-md-4 col-lg-3">
                                        <div class="category-card mx-auto">
                                            <img src="{{ asset('images/default_female_pfp.jpg') }}" 
                                                 alt="{{ $categoria['nombre'] }}" 
                                                 class="img-fluid mb-3">
                                            <h4 class="fs-5 text-center">{{ $categoria['nombre'] }}</h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" 
                        type="button" 
                        data-bs-target="#categoriasCarousel" 
                        data-bs-slide="prev">
                    <i class="bi bi-chevron-left fs-4 text-black"></i>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" 
                        type="button" 
                        data-bs-target="#categoriasCarousel" 
                        data-bs-slide="next">
                    <i class="bi bi-chevron-right fs-4 text-black"></i>
                    <span class="visually-hidden">Siguiente</span>
                </button>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    @foreach (array_chunk(['Música', 'Gaming', 'Deporte', 'Arte', 'Cine', 'Tecnología'], 3) as $index => $grupo)
                        <button type="button" 
                                data-bs-target="#categoriasCarousel" 
                                data-bs-slide-to="{{ $index }}" 
                                class="{{ $index == 0 ? 'active' : '' }}" 
                                aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Users Section -->
    <section class="destacados-section py-5" id="usuariosDestacados">
        <div class="container">
            <h4 class="text-center fs-2 text-dark">Usuarios Destacados</h4>
            <p class="text-center text-muted mb-5">Descubre a nuestros usuarios más populares y sus habilidades</p>
            
            <div class="row g-4">
                @foreach ([
                    ['nombre' => 'Lucas Pérez', 'tag' => 'Popular', 'emoji' => '⭐', 'desc' => 'Diseño interfaces atractivas y responsivas con React y Tailwind.'],
                    ['nombre' => 'Ana Torres', 'tag' => 'Tendencia', 'emoji' => '🔥', 'desc' => 'Desarrollo backends seguros y escalables con Node.js y PostgreSQL.'],
                    ['nombre' => 'Martín Rojas', 'tag' => 'Mejor valorado', 'emoji' => '🏆', 'desc' => 'Construyo webs completas, desde el frontend hasta el backend.']
                ] as $usuario)
                    <div class="col-md-4">
                        <div class="profile-card h-100">
                            <span class="tag">
                                {{ $usuario['emoji'] }} {{ $usuario['tag'] }}
                            </span>
                            <br>
                            <br>
                            <div class="profile-image">
                                <img src="{{ asset('images/default_male_pfp.jpg') }}" 
                                     alt="{{ $usuario['nombre'] }}" 
                                     class="img-fluid">
                            </div>
                            <br>
                            <h5 class="fs-5 fw-bold mb-2">{{ $usuario['nombre'] }}</h5>
                            <p class="text-muted mb-4">{{ $usuario['desc'] }}</p>
                            <div class="d-flex justify-content-end">
                                <a href="/perfil/{{ strtolower(str_replace(' ', '-', $usuario['nombre'])) }}" class="btn btn-primary btn-view">Ver perfil</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="/usuarios" class="btn btn-primary">Ver todos los usuarios</a>
            </div>
        </div>
    </section>

    <!-- Token Section -->
    <section class="token-section py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">
                        ¿Consideras que no tienes habilidades?
                    </h2>
                    <p class="lead mb-4">
                        En nuestra plataforma, puedes adquirir <span class="fw-bold">TokenSkills</span>, nuestra moneda digital, para acceder a diversos servicios.
                        Si dispones de una cantidad significativa de tokens y habilidades, también tienes la opción de venderlos y recibir una compensación económica.
                    </p>
                    <button type="button" class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#tokensModal">
                        Ver paquetes de tokens
                    </button>
                </div>
                <div class="col-lg-6">
                    <div id="tokensCarousel" class="carousel slide" data-bs-ride="carousel">
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
                                    <div class="token-card mx-auto" style="max-width: 300px;">
                                        <div class="token-card-content">
                                            <div class="token-coin-container">
                                                @php
                                                    $numCoins = min(1, intval($pack['tokens'] / 100)); // Máximo 5 monedas
                                                @endphp
                                                @for ($i = 0; $i < $numCoins; $i++)
                                                    <img src="{{ asset('images/coin.png') }}" 
                                                         alt="TokenSkills" 
                                                         class="token-coin"
                                                         style="
                                                            ">
                                                @endfor
                                            </div>
                                            <h5 class="fs-4 mb-2">{{ $pack['tokens'] }} TokenSkills</h5>
                                            <p class="fs-5 mb-3 fw-bold">{{ $pack['precio'] }}€</p>
                                            <a href="/comprar/{{ $pack['tokens'] }}/{{ $pack['precio'] }}" class="btn btn-subscribe w-100">Comprar ahora</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#tokensCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tokensCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>

                        <br><br>

                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators">
                            @foreach ([100, 250, 500, 1000, 2000] as $index => $tokens)
                                <button type="button" 
                                        data-bs-target="#tokensCarousel" 
                                        data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index == 0 ? 'active' : '' }}" 
                                        aria-label="{{ $tokens }} tokens"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tokens Modal -->
    <div class="modal fade" id="tokensModal" tabindex="-1" aria-labelledby="tokensModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tokensModalLabel">Paquetes de TokenSkills</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach ([
                            ['tokens' => 100, 'precio' => 4.99],
                            ['tokens' => 250, 'precio' => 9.99],
                            ['tokens' => 500, 'precio' => 24.99],
                            ['tokens' => 1000, 'precio' => 45.99],
                            ['tokens' => 2000, 'precio' => 99.99]
                        ] as $pack)
                            <div class="token-card" style="width: 220px;">
                                <div class="token-card-content">
                                    <div class="token-coin-container">
                                        @php
                                            $numCoins = min(5, intval($pack['tokens'] / 100)); // Máximo 5 monedas
                                        @endphp
                                        @for ($i = 0; $i < $numCoins; $i++)
                                            <img src="{{ asset('images/coin.png') }}" 
                                                 alt="TokenSkills" 
                                                 class="token-coin"
                                                 style="
                                                    transform: translate({{ ($i - ($numCoins-1)/2) * 10 }}px, -50%);
                                                    z-index: {{ $i }};
                                                    max-height: 50px;
                                                 ">
                                        @endfor
                                    </div>
                                    <h5 class="fs-5 mb-2">{{ $pack['tokens'] }} TokenSkills</h5>
                                    <p class="fs-6 mb-3 fw-bold">{{ $pack['precio'] }}€</p>
                                    <a href="/comprar/{{ $pack['tokens'] }}/{{ $pack['precio'] }}" class="btn btn-primary w-100">Comprar ahora</a>
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

    <!-- Call to Action Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fs-1 mb-4">¿Listo para comenzar?</h2>
                    <p class="lead mb-4">Únete a nuestra comunidad y empieza a intercambiar habilidades hoy mismo.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/registrarse" class="btn btn-primary btn-lg">Registrarse</a>
                        <a href="/servicios" class="btn btn-outline-primary btn-lg">Explorar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection