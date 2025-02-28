@extends('layout')

@section('title', 'Listado de usuarios')

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
                                    <div class="category-card mx-auto"></div>
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
                    <div class="profile-card bg-white">
                        <span class="tag fs-4">{{ $usuario['tag'] }}</span>
                        <div class="profile-image">
                            <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Screenshot_20250228_094726-9OK3lC2W03T5jMEdWS5L1OAHLpgGlT.png" alt="Profile Image" class="img-fluid">
                        </div>
                        <p class="fs-5">{{ $usuario['nombre'] }}</p>
                        <p>{{ $usuario['desc'] }}</p>
                        <button class="btn btn-view">Ver perfil</button>
                    </div>
                </div>
            @endforeach
        </div>
            </div>
    </section>

    <section class="token-section p-5">
        <div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="fs-1">¿Consideras que no tienes habilidades?</h5>
                    <p class="fs-5">En nuestra plataforma, puedes adquirir <b>TokenSkills</b>, nuestra moneda digital, para acceder a diversos servicios. Si dispones de una cantidad significativa de tokens y habilidades, también tienes la opción de venderlos y recibir una compensación económica.</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        @foreach ([['tokens' => 200, 'precio' => 9], ['tokens' => 1000, 'precio' => 20]] as $pack)
                            <div class="col-md-6">
                                <div class="token-card">
                                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Screenshot_20250228_094726-9OK3lC2W03T5jMEdWS5L1OAHLpgGlT.png" alt="Coins" class="img-fluid mb-3">
                                    <h5 class="text-black icon-box">{{ $pack['tokens'] }} TokenSkills</h5>
                                    <p class="fs-4 mb-3 text-black icon-box">{{ $pack['precio'] }}€</p>
                                    <button class="btn btn-buy text-black">Comprar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection