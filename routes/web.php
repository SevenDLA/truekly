<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test usuario
Route::get('/test/{id_servicio?}', [ServiceController::class, 'service_formulario']);

// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/perfil', [UserController::class, 'perfil'])->name('profile.normal');
    Route::post('/profile/upload-image', [UserController::class, 'updateImage'])->name('profile.upload.image');

});

// Servicios
Route::middleware('auth')->group(function () {
    Route::delete('/eliminar_servicio/{id}', [ServiceController::class, 'eliminar_servicio_usuario']);
    Route::post('/nuevo_servicio', [ServiceController::class, 'almacenar_servicio'])->name('service.store');
    Route::get('/servicio/{id_servicio?}', [ServiceController::class, 'service_formulario']);
});

Route::get('servicio/ver/{id_servicio}', [ServiceController::class,'mostrar']);

// Compra y venta de tokens
Route::middleware('auth')->group(function () {
    Route::get('/comprar/{cantidad_tokens}/{precio_tokens}', function ($cantidad_tokens, $precio_tokens) {
        return view('buy', compact('cantidad_tokens', 'precio_tokens'));
    });

    Route::post('/actualizar-tokens', [UserController::class, 'updateTokens'])->name('update.tokens');

    Route::get('/vender', function () {
        return view('sell');
    });
});

// Administración
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');

    Route::get('/admin/listado', [UserController::class, 'listado'])->name('users.listado');
    Route::get('/admin/servicios', [ServiceController::class, 'listado'])->name('services.listado');
});

// Gestión de usuarios
Route::get('/user/{id}', [UserController::class, 'mostrar'])->name('users.mostrar');
Route::get('/user/actualizar/{id}', [UserController::class, 'actualizar'])->name('users.actualizar');
Route::get('/user/eliminar/{id}', [UserController::class, 'eliminar'])->name('users.eliminar');
Route::get('/users/nuevo', [UserController::class, 'alta'])->name('users.alta');
Route::post('/users/nuevo', [UserController::class, 'almacenar'])->name('users.almacenar');

// Servicios
Route::get('/servicios', [ServiceController::class, 'listado'])->name('services.listado');
Route::get('/servicio/{id}', [ServiceController::class, 'mostrar'])->name('services.mostrar');

// Actualización de usuario vía AJAX
Route::middleware('auth')->post('/update-user-info', [UserController::class, 'updateUserInfo']);
Route::get('/user/{id}/services/ajax', [ServiceController::class, 'getUserServicesAjax']);

// Autenticación
require __DIR__.'/auth.php';
