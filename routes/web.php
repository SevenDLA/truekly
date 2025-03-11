<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test usuario
Route::get('/test/{userInfo}', [UserController::class, 'userExists']);

// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/perfil', [UserController::class, 'perfil'])->name('profile.normal');
});

// Servicios
Route::middleware('auth')->group(function () {
    Route::delete('/eliminar_servicio/{id}', [ServiceController::class, 'eliminar_servicio_usuario']);
    Route::get('/editar_servicio/{id_usuario}/{id_servicio}', [ServiceController::class, 'modificar_servicio_usuario'])->name('editar_servicio');
    Route::get('/nuevo_servicio/{id_usuario}', [ServiceController::class, 'service_formulario']);
    Route::post('/nuevo_servicio/{id_usuario}', [ServiceController::class, 'almacenar_servicio'])->name('service.store');
});

// Compra y venta de tokens
Route::middleware('auth')->group(function () {
    Route::get('/buy/{cantidad_tokens}/{precio_tokens}', function ($cantidad_tokens, $precio_tokens) {
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
    Route::get('/admin/services', [ServiceController::class, 'listado'])->name('services.listado');
});

// Gestión de usuarios
Route::get('/user/{id}', [UserController::class, 'mostrar'])->name('users.mostrar');
Route::get('/user/actualizar/{id}', [UserController::class, 'actualizar'])->name('users.actualizar');
Route::get('/user/eliminar/{id}', [UserController::class, 'eliminar'])->name('users.eliminar');
Route::get('/users/nuevo', [UserController::class, 'alta'])->name('users.alta');
Route::post('/users/nuevo', [UserController::class, 'almacenar'])->name('users.almacenar');

// Servicios
Route::get('/services', [ServiceController::class, 'listado'])->name('services.listado');
Route::get('/service/{id}', [ServiceController::class, 'mostrar'])->name('services.mostrar');

// Mensajería (Chat)
Route::middleware('auth')->group(function () {
    Route::get('/mensajes', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/mensajes/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/mensajes/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/mensajes/iniciar/{user}', [MessageController::class, 'start'])->name('messages.start');
    Route::post('/mensajes/marcar-leido/{message}', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
});

// Conversaciones
Route::middleware('auth')->group(function () {
    Route::get('/messages', [ConversationController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [ConversationController::class, 'createForm'])->name('messages.createForm');
    Route::post('/messages', [ConversationController::class, 'create'])->name('messages.create');
    Route::get('/messages/{conversation}', [ConversationController::class, 'show'])->name('messages.show');
});

// Actualización de usuario vía AJAX
Route::middleware('auth')->post('/update-user-info', [UserController::class, 'updateUserInfo']);
Route::get('/user/{id}/services/ajax', [ServiceController::class, 'getUserServicesAjax']);

// Configuración de Livewire
Livewire::setScriptRoute(fn ($handle) => Route::get('/livewire/livewire.js', $handle));
Livewire::setUpdateRoute(fn ($handle) => Route::post('/livewire/update', $handle));

// Autenticación
require __DIR__.'/auth.php';
