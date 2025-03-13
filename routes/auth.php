<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('registrarse', [RegisteredUserController::class, 'create'])
        ->name('registrarse');

    Route::post('registrarse', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('olvidar-contrasena', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('olvidar-contrasena', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('cambiar-contrasena/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('cambiar-contrasena', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirmar-contrasena', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirmar-contrasena', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
    })->middleware('auth');
