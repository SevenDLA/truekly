<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="Panel de administración de Truekly - Gestiona usuarios, servicios y contenido de la plataforma de manera eficiente">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navigation')
        <!-- Sidebar -->
        
        <!-- Contenido Principal -->
        <div class="content-wrapper">
        @yield('content')
        </div>
        <!-- Footer -->
    
    </div>
</body>
</html>