<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
*Seleção de Idioma
*/

Route::get('/ptbr', [HomeController::class, 'getLangPortuguese'])->name('lang.portuguese')->middleware('define.locale');

Route::get('/en', [HomeController::class, 'getLangEnglish'])->name('lang.english')->middleware('define.locale');

Route::get('/es', [HomeController::class, 'getLangSpanish'])->name('lang.spanish')->middleware('define.locale');

// Route::get('lang/{locale}', [UserController::class, 'lang']);

Route::get('/', function () {
    return view('welcome');
});
