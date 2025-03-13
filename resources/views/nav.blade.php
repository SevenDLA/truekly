<nav class="navbar navbar-expand-lg p-3 sticky-top">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="/">
      <img src="{{ asset('images/truekly.png') }}" class="img-fluid logo" alt="Truekly">
    </a>
    
    <!-- Botón del menú móvil -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" 
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <i class="bi bi-list text-white fs-2"></i>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto me-auto">
        <ul class="nav nav-underline d-flex align-items-center">
          <li class="nav-item mx-1">
            <a class="nav-link fw-medium" aria-current="page" href="#">
              <i class="bi bi-shop me-1"></i>Tienda
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link fw-medium" href="#" data-bs-toggle="modal" data-bs-target="#nosotrosModal">
              <i class="bi bi-info-circle me-1"></i>Nosotros
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link fw-medium" href="#">
              <i class="bi bi-cart me-1"></i>Carrito
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link fw-medium" href="/servicios">
              <i class="bi bi-briefcase me-1"></i>Servicios
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link fw-medium" href="/mensajes">
              <i class="bi bi-chat me-1"></i>Mensajes
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link fw-medium" href="/perfil">
              <i class="bi bi-person me-1"></i>Perfil
            </a>
          </li>
        </ul>
      </div>
      
      <!-- Formulario de búsqueda y login -->
      <div class="d-flex align-items-center mt-3 mt-lg-0">
        <div class="dropdown me-2">
          <button class="btn btn-search" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-search text-white"></i>
          </button>
          <div class="dropdown-menu p-3 dropdown-menu-end search-dropdown">
            <form class="d-flex" role="search">
              <input class="form-control me-2 border-primary" type="search" placeholder="¿Qué estás buscando?" aria-label="Search">
              <button class="btn btn-primary" type="submit">Buscar</button>
            </form>
          </div>
        </div>
        <a class="btn btn-login ms-2" href="/login">
          <i class="bi bi-box-arrow-in-right me-1"></i>
          <span class="d-none d-md-inline">Iniciar sesión</span>
        </a>
      </div>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>