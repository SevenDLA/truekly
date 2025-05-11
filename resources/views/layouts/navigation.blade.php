<nav class="navbar navbar-dark bg-dark sticky-top p-2 p-md-3">
       <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/truekly.png') }}" class="img-fluid" alt="Truekly" style="max-height: 40px;">
        </a>

        <div class="d-flex flex-grow-1 justify-content-center">
            <div class="navbar-nav ms-auto me-auto">
                <ul class="nav nav-underline d-flex align-items-center flex-nowrap overflow-auto">
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::is('admin') ? 'border-bottom border-3' : '' }}" href="/admin">
                            <i class="bi bi-house"></i><span class="d-none d-xl-inline ms-1">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::routeIs('users.listado') ? 'border-bottom border-3' : '' }}" href="{{ route('users.listado') }}">
                            <i class="bi bi-people"></i><span class="d-none d-xl-inline ms-1">Usuarios</span>
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::routeIs('services.admin.listado') ? 'border-bottom border-3' : '' }}" href="{{ route('services.admin.listado') }}">
                            <i class="bi bi-briefcase"></i><span class="d-none d-xl-inline ms-1">Servicios</span>
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::routeIs('admin.compras.listado') ? 'border-bottom border-3' : '' }}" href="{{ route('admin.compras.listado') }}">
                            <i class="bi bi-bag"></i><span class="d-none d-xl-inline ms-1">Compras</span>
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link fw-medium {{ Request::routeIs('admin.offers.listado') ? 'border-bottom border-3' : '' }}" href="{{ route('admin.offers.listado') }}">
                            <i class="bi bi-tag"></i><span class="d-none d-xl-inline ms-1">Ofertas</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                @auth
                    <button type="button" class="btn btn-login btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-box-arrow-in-left"></i><span class="d-none d-xl-inline ms-1">Salir</span>
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