<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PayPalController;

use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test 
Route::get('/testing/{id_oferta}', [OfferController::class, 'ver_oferta']);
Route::get('/test', function () {
    return view('test');
});

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
    Route::post('/anhadir_servicio_carrito', [ServiceController::class, 'anhadir_servicio_carrito']);
    Route::post('/quitar_servicio_carrito', [ServiceController::class, 'quitar_servicio_carrito']);
    Route::post('/servicio/acceptar', [CompraController::class,'pagar_seller']);
});

Route::get('servicio/ver/{id_servicio}', [ServiceController::class,'mostrar']);

// Compra y venta de tokens
Route::middleware('auth')->group(function () {
    Route::get('/comprar/{cantidad_tokens}/{precio_tokens}/{seller?}', function ($cantidad_tokens, $precio_tokens, $seller = null) {
        return view('buy', compact('cantidad_tokens', 'precio_tokens', 'seller'));
    });
    

    Route::post('/actualizar-tokens', [UserController::class, 'updateTokens'])->name('update.tokens');

    Route::get('/vender', function () {
        return view('sell');
    });

    Route::get('marketplace', function(){
        return view ('marketplace');
    });

    Route::get('/marketplace', [OfferController::class, 'coger_todas_ofertas'])->name('offers.listado');
});

// Administración
Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');

    Route::get('/admin/listado', [UserController::class, 'listado'])->name('users.listado');
    Route::get('/admin/servicios', [ServiceController::class, 'listado_admin'])->name('services.admin.listado');
});

// Gestión de usuarios
Route::get('/admin/user/{id}', [UserController::class, 'mostrar'])->name('users.mostrar');
//Route::pu('/admin/user/actualizar/{id}', [UserController::class, 'actualizar'])->name('users.actualizar');
Route::delete('/admin/user/eliminar/{id}', [UserController::class, 'eliminar'])->name('users.eliminar');
Route::get('/users/nuevo', [UserController::class, 'alta'])->name('users.alta');
Route::post('/users/nuevo', [UserController::class, 'almacenar'])->name('users.almacenar');

// Servicios
Route::get('/servicios', [ServiceController::class, 'listado'])->name('services.listado');
Route::get('/servicio/{id}', [ServiceController::class, 'mostrar'])->name('services.mostrar');

// Actualización de usuario vía AJAX
Route::middleware('auth')->post('/update-user-info', [UserController::class, 'updateUserInfo']);
Route::get('/user/{id}/services/ajax', [ServiceController::class, 'getUserServicesAjax']);

//Carrito
Route::get('/carrito', function () {
    return view('carrito');
});
Route::post('/carrito/nuevo', [CompraController::class, 'crear_compra']);
Route::post('/vaciar/carrito', [CompraController::class,'vaciar_carrito']);

//Compras
Route::post('/usario/servicio/comprados', [CompraController::class,'user_servicios']);
Route::post('/pagar/vendedor/{id_compra}', [CompraController::class,'pagar_seller']);

//Ofertas
Route::get('/usuario/ofertas', [OfferController::class, 'coger_ofertas_usuario']);
Route::get('/oferta/{id_oferta?}', [OfferController::class, 'offer_formulario']);
Route::post('/nuevo_oferta', [OfferController::class, 'almacenar_offer'])->name('offer.store');

// PayPal
Route::post('/paypal/capture-offer-payment', [PayPalController::class, 'captureOfferPayment'])->name('paypal.captureOfferPayment');
Route::post('/paypal/buy-offer', [PayPalController::class, 'buyOffer'])->name('paypal.buyOffer');
Route::get('/paypal/success', [PayPalController::class, 'captureOfferPayment'])->name('paypal.success');
Route::get('/paypal/cancel', function () {
    return 'Payment canceled';
})->name('paypal.cancel');
Route::post('/paypal/send/payout', [PayPalController::class, 'sendPayout'])->name('send.payout');


// Autenticación
require __DIR__.'/auth.php';
