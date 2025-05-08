<?php

use App\Http\Controllers\{ProfileController, UserController, ServiceController, CompraController};
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::view('/', 'welcome');

// Dashboard
Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Test usuario
Route::get('/test/{id_servicio?}', [ServiceController::class, 'service_formulario']);

// Perfil de usuario (rutas protegidas por autenticación)
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/upload-image', [UserController::class, 'updateImage'])->name('profile.upload.image');
    });
    
    Route::get('/perfil', [UserController::class, 'perfil'])->name('profile.normal');
});

// Servicios (rutas protegidas por autenticación)
Route::middleware('auth')->group(function () {
    Route::prefix('servicio')->group(function () {
        Route::delete('/eliminar_servicio/{id}', [ServiceController::class, 'eliminar_servicio_usuario']);
        Route::post('/nuevo_servicio', [ServiceController::class, 'almacenar_servicio'])->name('service.store');
        Route::get('/{id_servicio?}', [ServiceController::class, 'service_formulario']);
        Route::post('/anhadir_servicio_carrito', [ServiceController::class, 'anhadir_servicio_carrito']);
        Route::post('/quitar_servicio_carrito', [ServiceController::class, 'quitar_servicio_carrito']);
    });
});

// Vista pública de servicios
Route::get('servicio/ver/{id_servicio}', [ServiceController::class, 'mostrar']);

// Compra y venta de tokens (rutas protegidas por autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/comprar/{cantidad_tokens}/{precio_tokens}', fn($cantidad, $precio) => 
        view('buy', compact('cantidad_tokens', 'precio_tokens'))
    )->whereNumber(['cantidad_tokens', 'precio_tokens']);

    Route::post('/actualizar-tokens', [UserController::class, 'updateTokens'])->name('update.tokens');
    Route::view('/vender', 'sell');
});

// Administración (rutas protegidas por autenticación)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin');
    Route::get('/listado', [UserController::class, 'listado'])->name('users.listado');
    Route::get('/servicios', [ServiceController::class, 'listado_admin'])->name('services.admin.listado');
});

// Gestión de usuarios
Route::prefix('admin/user')->group(function () {
    Route::get('/{id}', [UserController::class, 'mostrar'])->name('users.mostrar');
    Route::get('/actualizar/{id}', [UserController::class, 'actualizar'])->name('users.actualizar');
    Route::get('/eliminar/{id}', [UserController::class, 'eliminar'])->name('users.eliminar');
});

// Usuarios
Route::prefix('users')->group(function () {
    Route::get('/nuevo', [UserController::class, 'alta'])->name('users.alta');
    Route::post('/nuevo', [UserController::class, 'almacenar'])->name('users.almacenar');
});

// Servicios públicos
Route::prefix('servicios')->group(function () {
    Route::get('/', [ServiceController::class, 'listado'])->name('services.listado');
    Route::get('/{id}', [ServiceController::class, 'mostrar'])->name('services.mostrar');
});

// Actualización de usuario vía AJAX (protegida)
Route::middleware('auth')->group(function () {
    Route::post('/update-user-info', [UserController::class, 'updateUserInfo']);
    Route::get('/user/{id}/services/ajax', [ServiceController::class, 'getUserServicesAjax']);
});

// Carrito
Route::middleware('auth')->group(function () {
    Route::view('/carrito', 'carrito');
    Route::post('/carrito/nuevo', [CompraController::class, 'crear_compra']);
});

// Autenticación
require __DIR__.'/auth.php';