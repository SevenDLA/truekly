<nav class="navbar navbar-expand-lg navbar-light p-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('images/truekly.png') }}" class="img-fluid logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="visibility:initial">
      <div class="navbar-nav">
      <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/services">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/perfil">Perfil</a>
                </li>
           </ul>
           <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      </div>
    </div>
  </div>
  <a class="nav-link" style="font-size:30px;float:right;margin-right:20px" href="/login"><i class="bi bi-box-arrow-in-right"></i></a>
</nav>
