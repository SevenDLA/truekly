<nav class="main-header navbar navbar-expand navbar-dark navbar-primary fixed-top">
    <!-- Left navbar links -->
    <div class="container-fluid">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <x-application-logo style="height: 35px; filter: brightness(0) invert(1);" />
            <span class="brand-text font-weight-light">Tu Aplicación</span>
        </a>

        <!-- Left Sidebar Toggle -->
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.listado') }}" class="nav-link @if(request()->routeIs('users.listado')) active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('services.listado') }}" class="nav-link @if(request()->routeIs('services.listado')) active @endif">
                        <i class="nav-icon fas fa-concierge-bell"></i>
                        Servicios
                    </a>
                </li>
            </ul>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- User Dropdown Menu -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('vendor/adminlte/dist/img/avatar.png') }}" 
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('vendor/adminlte/dist/img/avatar.png') }}" 
                             class="img-circle elevation-2" alt="User Image">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Miembro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">
                            <i class="fas fa-user-cog mr-2"></i>Perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat float-right">
                                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>