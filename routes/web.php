<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Coordenador\CoordenadorController;
use App\Http\Controllers\Coordenador\ConfiguraInscricaoPosController;
use App\Http\Controllers\Candidato\CandidatoController;
use App\Http\Controllers\Recomendante\RecomendanteController;
use App\Livewire\ListaUsuarios;

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
 * Rotas para definir idiomas
*/

Route::get('/ptbr', [HomeController::class, 'getLangPortuguese'])->name('lang.portuguese')->middleware('define.locale');

Route::get('/en', [HomeController::class, 'getLangEnglish'])->name('lang.english')->middleware('define.locale');

Route::get('/es', [HomeController::class, 'getLangSpanish'])->name('lang.spanish')->middleware('define.locale');


/*
* Home
*/
Route::get('/', [HomeController::class, 'index'])->middleware('define.locale')->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
 * Rotas para as funções do admin
*/

// Route::prefix('admin')->middleware(['user.role:admin','auth', 'verified'])->group(function () {
//     Route::get('/', [AdminController::class, 'getMenu'])->name('menu.admin');
// })->name('admin');

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'getMenu'])->name('menu.admin');
    Route::get('configura/inscricao', [ConfiguraInscricaoPosController::class, 'getConfiguraInscricao'])->name('configura.inscricao');
});


/*
 * Rotas para as funções do coordenador
*/

Route::prefix('coordenador')->middleware(['auth', 'verified', 'user.role:coordenador,admin'])->group(function () {
    Route::get('/', [CoordenadorController::class, 'getMenu'])->name('menu.coordenador');
})->name('coordenador');

/*
 * Rotas para as funções do candidato
*/

Route::prefix('candidato')->middleware(['auth', 'verified','user.role:candidato'])->group(function () {
    Route::get('/', [CandidatoController::class, 'getMenu'])->name('menu.candidato');
})->name('candidato');

/*
 * Rotas para as funções do recomendante
*/

Route::prefix('recomendante')->middleware(['auth', 'verified', 'user.role:recomendante'])->group(function () {
    Route::get('/', [RecomendanteController::class, 'getMenu'])->name('menu.recomendante');
})->name('recomendante');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
 * Logout
*/
Route::get('/logout', [HomeController::class, 'index'])->name('logout');


require __DIR__.'/auth.php';
