<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top p-2 p-md-3">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/truekly.png') }}" class="img-fluid" alt="Truekly" style="max-height: 40px;">
        </a>

        <!-- Botón del menú móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Menú principal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-medium @if(request()->is('admin')) active @endif" href="/admin">
                        <i class="bi bi-house me-1"></i>Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium @if(request()->routeIs('users.listado')) active @endif" 
                       href="{{ route('users.listado') }}">
                        <i class="bi bi-people me-1"></i>Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium @if(request()->routeIs('services.admin.listado')) active @endif" 
                       href="{{ route('services.admin.listado') }}">
                        <i class="bi bi-briefcase me-1"></i>Servicios
                    </a>
                </li>
            </ul>

            <!-- Elementos de autenticación -->
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2">
                @guest
                    <a class="btn btn-outline-light w-100 w-lg-auto" href="/login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        <span class="d-none d-lg-inline">Iniciar sesión</span>
                    </a>
                @endguest
                
                @auth
                    <button type="button" class="btn btn-outline-light w-100 w-lg-auto" 
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-box-arrow-in-left me-1"></i>
                        <span class="d-none d-lg-inline">Cerrar sesión ({{ Auth::user()->username }})</span>
                    </button>
                @endauth
            </div>
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