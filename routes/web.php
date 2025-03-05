<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update']) ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/perfil',     [UserController::class,    'perfil']) ->name('profile.normal');

    Route::delete('/eliminar_servicio/{id}', [ServiceController::class, 'eliminar_servicio_usuario']);
    Route::get('/editar_servicio/{id_usuario}/{id_servicio}', [ServiceController::class, 'modificar_servicio_usuario'])
    ->name('editar_servicio');

    Route::get('/nuevo_servicio/{id_usuario}', [ServiceController::class, 'service_formulario']);
    Route::post('/nuevo_servicio/{id_usuario}', [ServiceController::class, 'almacenar_servicio'])->name('service.store');
    
    Route::get('/buy', function(){
        return view('buy');
    });
});



# Route::get('/users'       , [UserController::class, 'listado'])->name('users.listado');


Route::get('/user/{id}'            , [UserController::class, 'mostrar'])->name('users.mostrar');
Route::get('/user/actualizar/{id}' , [UserController::class, 'actualizar'])->name('users.actualizar');
Route::get('/user/eliminar/{id}'   , [UserController::class, 'eliminar'])->name('users.eliminar');
Route::get('/users/nuevo'          , [UserController::class, 'alta'])->name('users.alta');
Route::post('/users/nuevo'         , [UserController::class, 'almacenar'])->name('users.almacenar');

Route::get('/services'       , [ServiceController::class, 'listado'])->name('services.listado');

Route::get('/service/{id}'            , [serviceController::class, 'mostrar'])->name('services.mostrar');
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin');

Route::get('/admin/listado', [UserController::class, 'listado'])->middleware('auth')->name('users.listado');

Route::get('/admin/services', [ServiceController::class, 'listado'])->middleware('auth')->name('services.listado');

Route::post('/update-user-info', [UserController::class, 'updateUserInfo'])->middleware('auth');

Route::get('/user/{id}/services/ajax', [ServiceController::class, 'getUserServicesAjax']);


require __DIR__.'/auth.php';
