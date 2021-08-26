<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrarController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/ptbr', [HomeController::class, 'getLangPortugues'])->middleware('idioma.site')->name('lang.portugues');

Route::get('/en', [HomeController::class, 'getLangIngles'])->middleware('idioma.site')->name('lang.ingles');

Route::get('/es', [HomeController::class, 'getLangEspanhol'])->middleware('idioma.site')->name('lang.espanhol');

Route::get('/', [HomeController::class, 'index'])->middleware('idioma.site')->name('home');

Route::get('/candidato', function () {
    return view('candidato.index');
})->middleware('verified');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'logar']);

Route::get('/register', [RegistrarController::class, 'index'])->name('registrar');

Route::post('/register', [RegistrarController::class, 'registrar']);

Route::get('/forgot-password', [RecuperaSenhaController::class, 'create'])->middleware('guest')->name('password.request');

Route::post('/forgot-password', [RecuperaSenhaController::class, 'store'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', [NovaSenhaController::class, 'create'])->middleware('guest')->name('password.reset');

Route::post('/reset-password', [NovaSenhaController::class, 'store'])->middleware('guest')->name('password.update');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');