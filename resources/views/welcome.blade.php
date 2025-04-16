@extends('layout')

@section('title', 'Truekly - Plataforma de intercambio de habilidades')

@section('content')
    <!-- Hero Section Mejorada -->
    <section class="welcome-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="animate-fadeInUp">Bienvenido a <span style="color: var(--primary);">Truekly</span></h1>
                    <p class="lead text-white mt-4 animate-fadeInUp animate-delay-1"
                        style="max-width: 700px; margin: 0 auto;">
                        La plataforma donde puedes comprar, vender e intercambiar habilidades y servicios con otros
                        usuarios.
                    </p>
                    <div class="mt-5 animate-fadeInUp animate-delay-2">
                        <a href="#como-funciona" class="btn btn-primary btn-lg me-2">
                            <i class="bi bi-arrow-down-circle"></i> Descubre cómo funciona
                        </a>
                        <a href="/servicios" class="btn btn-search btn-lg">
                            <i class="bi bi-search"></i> Explorar servicios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section Mejorada -->
    <section id="como-funciona" class="funcion-section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="tag">Plataforma única</span>
                <h2 class="fs-1">¿Cómo funciona nuestra plataforma?</h2>
                <p class="lead text-muted">Descubre las tres formas de aprovechar Truekly</p>
            </div>
            <div class="row justify-content-center g-4">
                @foreach ([['titulo' => 'Compra', 'icono' => 'bi-cash-coin', 'desc' => 'Adquiere habilidades y servicios de otros usuarios utilizando nuestros TokenSkills.'], ['titulo' => 'Intercambia', 'icono' => 'bi-arrow-left-right', 'desc' => 'Ofrece tus habilidades a cambio de otras sin necesidad de usar dinero.'], ['titulo' => 'Vende', 'icono' => 'bi-piggy-bank', 'desc' => 'Monetiza tus conocimientos y habilidades ofreciéndolos en nuestra plataforma.']] as $index => $item)
                    <div class="col-md-4">
                        <div class="icon-box h-100 text-center">
                            <i class="bi {{ $item['icono'] }}"></i>
                            <h5 class="fs-5 mt-3">{{ $item['titulo'] }}</h5>
                            <p class="text-muted mt-3">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Categories Section Mejorada -->
    <section class="categorias-section" id="categorias">
        <div class="container">
            <div class="text-center mb-5">
                <span class="tag">Diversidad</span>
                <h3 class="fs-2">Explora por Categorías</h3>
                <p class="text-muted">Encuentra servicios y habilidades según tus intereses</p>
            </div>

            <div id="categoriasCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Carousel Inner -->
                <div class="carousel-inner">
                    @foreach (array_chunk([['nombre' => 'Música', 'icono' => 'bi-music-note', 'desc' => 'Instrumentos, producción, composición'], ['nombre' => 'Gaming', 'icono' => 'bi-controller', 'desc' => 'Coaching en videojuegos, streaming'], ['nombre' => 'Deporte', 'icono' => 'bi-activity', 'desc' => 'Entrenamiento personal, nutrición'], ['nombre' => 'Arte', 'icono' => 'bi-palette', 'desc' => 'Clases de dibujo, pintura, escultura y más'], ['nombre' => 'Cine', 'icono' => 'bi-film', 'desc' => 'Edición de video, guiones, actuación'], ['nombre' => 'Tecnología', 'icono' => 'bi-cpu', 'desc' => 'Programación, diseño web, análisis de datos']], 3) as $index => $grupo)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row justify-content-center">
                                @foreach ($grupo as $categoria)
                                    <div class="col-md-4">
                                        <div class="category-card">
                                            <div class="text-center mb-3">
                                                <i class="bi {{ $categoria['icono'] }} fs-1"
                                                    style="color: var(--primary);"></i>
                                            </div>
                                            <h4 class="fs-5 text-center mb-3">{{ $categoria['nombre'] }}</h4>
                                            <p class="text-muted text-center mb-3">{{ $categoria['desc'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>



                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    @foreach (array_chunk(['Música', 'Gaming', 'Deporte', 'Arte', 'Cine', 'Tecnología'], 3) as $index => $grupo)
                        <button type="button" data-bs-target="#categoriasCarousel" data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="/servicios" class="btn btn-outline-primary"><i class="bi bi-grid"></i>Ver todos los servicios </a>
            </div>
        </div>
    </section>

    <!-- Featured Users Section Mejorada -->
    <section class="destacados-section py-5" id="usuariosDestacados">
        <div class="container">
            <div class="text-center mb-5">
                <span class="tag">Talento destacado</span>
                <h4 class="fs-2 text-dark">Usuarios Destacados</h4>
                <p class="text-muted">Descubre a nuestros usuarios más populares y sus habilidades</p>
            </div>

            <div class="row g-4">
                @foreach ([['nombre' => 'Lucas Pérez', 'tag' => 'Popular', 'emoji' => '⭐', 'desc' => 'Diseño interfaces atractivas y responsivas con React y Tailwind.', 'rating' => 4.9], ['nombre' => 'Ana Torres', 'tag' => 'Tendencia', 'emoji' => '🔥', 'desc' => 'Desarrollo backends seguros y escalables con Node.js y PostgreSQL.', 'rating' => 4.8], ['nombre' => 'Martín Rojas', 'tag' => 'Mejor valorado', 'emoji' => '🏆', 'desc' => 'Construyo webs completas, desde el frontend hasta el backend.', 'rating' => 5.0]] as $usuario)
                    <div class="col-md-4">
                        <div class="profile-card h-100">
                            <span class="tag">
                                {{ $usuario['emoji'] }} {{ $usuario['tag'] }}
                            </span>
                            <div class="profile-image">
                                <img src="{{ asset('images/default_male_pfp.jpg') }}" alt="{{ $usuario['nombre'] }}"
                                    class="img-fluid">
                            </div>
                            <h5 class="fs-5 fw-bold mb-2">{{ $usuario['nombre'] }}</h5>

                            <!-- Valoración con estrellas -->
                            <div class="mb-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($usuario['rating']))
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @elseif ($i - 0.5 <= $usuario['rating'])
                                        <i class="bi bi-star-half text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-warning"></i>
                                    @endif
                                @endfor
                                <small class="ms-2 text-muted">({{ $usuario['rating'] }})</small>
                            </div>

                            <p class="text-muted mb-4">{{ $usuario['desc'] }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">
                                    <i class="bi bi-clock"></i> Disponible ahora
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Token Section Mejorada -->
    <section class="token-section py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="tag" style="background-color: rgba(255, 255, 255, 0.1); color: var(--text-light);">
                        <i class="bi bi-currency-exchange"></i> TokenSkills
                    </span>
                    <h2 class="display-5 fw-bold mb-4 text-primary">
                        ¿No tienes habilidades específicas para intercambiar?
                    </h2>
                    <p class="lead mb-4">
                        En nuestra plataforma, puedes adquirir <span class="fw-bold text-primary">TokenSkills</span>,
                        nuestra moneda digital, para acceder a diversos servicios.
                    </p>
                    <p class="mb-4">
                        Con TokenSkills podrás:
                    </p>
                    <ul class="mb-4 ps-0" style="list-style: none;">
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Contratar servicios directamente sin necesidad de ofrecer habilidades
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Recibir tokens por tus servicios y monetizarlos posteriormente
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            Acceder a servicios premium y usuarios destacados
                        </li>
                    </ul>
                    <button type="button" class="btn btn-outline-light btn-lg pulse" data-bs-toggle="modal"
                        data-bs-target="#tokensModal">
                        <i class="bi bi-cart-plus"></i> Ver paquetes de tokens
                    </button>
                </div>
                <div class="col-lg-6">
                    <div id="tokensCarousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Carousel Inner -->
                        <div class="carousel-inner">
                            @foreach ([['tokens' => 100, 'precio' => 4.99], ['tokens' => 250, 'precio' => 9.99], ['tokens' => 500, 'precio' => 24.99], ['tokens' => 1000, 'precio' => 45.99], ['tokens' => 2000, 'precio' => 89.99]] as $index => $pack)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="token-card mx-auto" style="max-width: 320px;">
                                        <div class="token-card-content">
                                            <div class="token-coin-container">
                                                <img src="{{ asset('images/coin.png') }}" alt="TokenSkills"
                                                    class="token-coin">
                                            </div>
                                            <h5 class="fs-3 mb-2">{{ $pack['tokens'] }} TokenSkills</h5>
                                            <p class="fs-4 mb-3 fw-bold">{{ $pack['precio'] }}€</p>
                                            <p class="text-muted mb-3">
                                                {{ round(($pack['precio'] / $pack['tokens']) * 100, 2) }}€ por cada 100
                                                tokens
                                            </p>
                                            <a href="/comprar/{{ $pack['tokens'] }}/{{ $pack['precio'] }}"
                                                class="btn btn-subscribe w-100">
                                                <i class="bi bi-bag-check"></i> Comprar ahora
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#tokensCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tokensCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>

                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators">
                            @foreach ([100, 250, 500, 1000, 2000] as $index => $tokens)
                                <button type="button" data-bs-target="#tokensCarousel"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-label="{{ $tokens }} tokens"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tokens Modal Mejorado -->
    <!-- Modal Paquetes TokenSkills con Scroll Horizontal -->
    <div class="modal fade" id="tokensModal" tabindex="-1" aria-labelledby="tokensModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-white text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="tokensModalLabel">
                        <i class="bi bi-currency-exchange me-2"></i> Elige tu paquete de TokenSkills
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="scroll-container d-flex gap-4 overflow-auto px-2 py-3">
                        @foreach ([['tokens' => 100, 'precio' => 4.99], ['tokens' => 250, 'precio' => 9.99], ['tokens' => 500, 'precio' => 24.99], ['tokens' => 1000, 'precio' => 45.99], ['tokens' => 2000, 'precio' => 89.99]] as $pack)
                            <div class="token-card bg-light text-dark p-4 rounded-4 shadow-sm"
                                style="min-width: 260px; max-width: 260px;">
                                <div class="text-center">
                                    <img src="{{ asset('images/coin.png') }}" alt="Token" class="mb-3"
                                        style="width: 50px;">
                                    <h5 class="fw-bold mb-1">{{ $pack['tokens'] }} TokenSkills</h5>
                                    <p class="fs-5 fw-semibold mb-1">{{ $pack['precio'] }}€</p>
                                    <p class="text-muted mb-3">{{ round(($pack['precio'] / $pack['tokens']) * 100, 2) }}€
                                        por cada 100 tokens</p>
                                    <a href="/comprar/{{ $pack['tokens'] }}/{{ $pack['precio'] }}"
                                        class="btn btn-primary w-100">
                                        <i class="bi bi-bag-check me-1"></i> Comprar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <div class="alert alert-primary" role="alert">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-info-circle-fill fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading mb-1">¿Cómo funcionan los TokenSkills?</h6>
                                    <p class="mb-0">Los TokenSkills son nuestra moneda virtual para intercambiar
                                        servicios en la plataforma. Puedes usarlos para adquirir habilidades o recibirlos al
                                        ofrecer las tuyas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>


    <!-- Call to Action Section Mejorada -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="tag">¡Empieza hoy!</span>
                    <h2 class="fs-1 mb-4">¿Listo para comenzar tu viaje en Truekly?</h2>
                    <p class="lead mb-4">Únete a nuestra comunidad y empieza a intercambiar habilidades hoy mismo.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="/registrarse" class="btn btn-primary btn-lg">
                            <i class="bi bi-person-plus"></i> Crear cuenta
                        </a>
                        <a href="/servicios" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-search"></i> Explorar servicios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
