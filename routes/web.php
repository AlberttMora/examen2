<?php

use App\Http\Controllers\ControllerAuth;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ControllerVisitantes;
use Illuminate\Support\Facades\Route;

// Solo para gente SIN sesión
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login');
    Route::get('/auth/google', [ControllerAuth::class, 'redirectGoogle'])->name('google');
    Route::get('/auth/google/callback', [ControllerAuth::class, 'callbackGoogle']);
});

// Solo para gente CON sesión
Route::middleware('auth')->group(function () {
    Route::redirect('/', '/listas');
    Route::resource('listas', ListaController::class)->except('show');
    Route::post('/logout', [ControllerAuth::class, 'logout'])->name('logout');
});

// La ruta pública /{token} de tu compañera va SIEMPRE al final
Route::post('/{token}/items/{id}', [ControllerVisitantes::class, 'update']);
Route::get('/{token}', [ControllerVisitantes::class, 'show']);