<nav class="navbar navbar-expand-lg p-2 p-md-3 sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/truekly.png') }}" class="img-fluid logo" alt="Truekly" style="max-height: 40px;">
        </a>

        <!-- Botón del menú móvil -->
        <div class="d-flex align-items-center">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list text-white fs-2"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto me-auto">
                <ul class="nav nav-underline d-flex align-items-center">
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('nosotros*') ? 'border-bottom border-3' : '' }}" href="#" data-bs-toggle="modal" data-bs-target="#nosotrosModal">
                            <i class="bi bi-info-circle me-1"></i>Nosotros
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('carrito*') ? 'border-bottom border-3' : '' }}" href="/carrito">
                            <i class="bi bi-cart me-1"></i>Carrito
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('servicios*') ? 'border-bottom border-3' : '' }}" href="/servicios">
                            <i class="bi bi-briefcase me-1"></i>Servicios
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('marketplace*') ? 'border-bottom border-3' : '' }}" href="/marketplace">
                            <i class="bi bi-coin me-1"></i>Marketplace
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('perfil*') ? 'border-bottom border-3' : '' }}" href="/perfil">
                            <i class="bi bi-person me-1"></i>Perfil
                        </a>
                    </li>
                    @hasrole('admin')
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('admin*') ? 'border-bottom border-3' : '' }}" href="/admin">
                            <i class="bi bi-shield-lock me-1"></i>Admin
                        </a>
                    </li>
                    @endrole
                </ul>
            </div>

            <!-- Formulario de búsqueda y login -->
            @guest
                <!-- Botón de login para escritorio -->
                <div class="d-none d-lg-flex align-items-center mt-3 mt-lg-0">
                    <a class="btn btn-login ms-2" href="/login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        <span class="d-none d-md-inline">Iniciar sesión</span>
                    </a>
                </div>

                <!-- Botón de login para móvil -->
                <div class="d-lg-none mt-3 text-center">
                    <a class="btn btn-login w-100" href="/login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Iniciar sesión
                    </a>
                </div>
            @endguest

            @auth
                <!-- Cerrar sesión para escritorio -->
                <div class="d-none d-lg-flex align-items-center mt-3 mt-lg-0">
                    <button type="button" class="btn btn-login ms-2" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-box-arrow-in-left me-1"></i>
                        <span class="d-none d-md-inline">Cerrar sesión (&#64;{{ Auth::user()->username }})</span>
                    </button>
                </div>

                <!-- Cerrar sesión para móvil -->
                <div class="d-lg-none mt-3 text-center">
                    <button type="button" class="btn btn-login w-100" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-box-arrow-in-left me-1"></i>
                        Cerrar sesión (&#64;{{ Auth::user()->username }})
                    </button>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Modal Nosotros -->
<div class="modal fade" id="nosotrosModal" tabindex="-1" aria-labelledby="nosotrosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nosotrosModalLabel">Nosotros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí va el contenido del modal -->
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <p>
                            Truekly nació de la idea de crear una plataforma donde las personas pudieran intercambiar
                            habilidades y servicios sin necesidad de dinero tradicional. Creemos en una economía
                            colaborativa donde todos tienen algo valioso que ofrecer.
                        </p>
                        <p>
                            Nuestro equipo está formado por profesionales apasionados por la tecnología y la economía
                            colaborativa.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Nuestros Valores</h5>
                        <ul>
                            <li><strong>Comunidad:</strong> Fomentamos la conexión entre personas.</li>
                            <li><strong>Transparencia:</strong> Todas nuestras operaciones son claras y accesibles.</li>
                            <li><strong>Inclusión:</strong> Creemos que todos tienen habilidades valiosas para
                                compartir.</li>
                            <li><strong>Sostenibilidad:</strong> Promovemos un consumo consciente y responsable.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Cerrar Sesión -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirmar cierre de sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas cerrar sesión?</p>
                <p class="text-muted small">Podrás volver a iniciar sesión en cualquier momento.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Sí, cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</div>