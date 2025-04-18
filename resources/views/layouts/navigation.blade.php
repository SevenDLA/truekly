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
                    <!-- Users Link -->
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium" href="/admin">
                            <i class="bi bi-house me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a href="{{ route('users.listado') }}"
                            class="nav-link fw-medium @if (request()->routeIs('users.listado')) active @endif">
                            <i class="bi bi-people me-1"></i>
                            Usuarios
                        </a>
                    </li>
                    <!-- Services Link -->
                    <li class="nav-item mx-1">
                        <a href="{{ route('services.admin.listado') }}"
                            class="nav-link fw-medium @if (request()->routeIs('services.admin.listado')) active @endif">
                            <i class="bi bi-briefcase me-1"></i>
                            Servicios
                        </a>
                    </li>
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
