<nav class="main-header navbar navbar-expand-lg navbar-dark navbar-primary fixed-top">
    <div class="container-fluid">
        <!-- Logo and Brand -->
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <x-application-logo style="height: 35px; filter: brightness(0) invert(1); margin-right: 20px;" />
            <img src="{{ asset('images/truekly.png') }}" class="img-fluid logo" alt="Truekly">
        </a>

        <!-- Left Sidebar Toggle Button -->
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>

                <!-- Users Link -->
                <li class="nav-item">
                    <a href="{{ route('users.listado') }}" class="nav-link @if(request()->routeIs('users.listado')) active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        Usuarios
                    </a>
                </li>

                <!-- Services Link -->
                <li class="nav-item">
                    <a href="{{ route('services.listado') }}" class="nav-link @if(request()->routeIs('services.listado')) active @endif">
                        <i class="nav-icon fas fa-concierge-bell"></i>
                        Servicios
                    </a>
                </li>

                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('images/default_male_pfp.jpg') }}" 
                             class="rounded-circle img-fluid" alt="User Image" style="width: 40px; height: 40px;">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <p>
                                <small>Miembro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                            </p>
                        </li>

                        <!-- Menu Footer -->
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
                </li>
            </ul>
        </div>
    </div>
</nav>
