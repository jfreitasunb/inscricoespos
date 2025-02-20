<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EditarInscricaoPosController;
use App\Http\Controllers\Admin\ListaUsuariosController;
use App\Livewire\ListaUsuarios;
use App\Livewire\ListaAreaPos;
use App\Livewire\ListaFormacao;
use App\Http\Controllers\Coordenador\CoordenadorController;
use App\Http\Controllers\Coordenador\ConfiguraInscricaoPosController;
use App\Http\Controllers\Coordenador\DadosCoordenadorPosController;
use App\Http\Controllers\Coordenador\CadastraAreaPosController;
use App\Http\Controllers\Candidato\CandidatoController;
use App\Http\Controllers\Candidato\DadosPessoaisCandidatoController;
use App\Http\Controllers\Recomendante\RecomendanteController;

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

Route::get('/ptbr', [BaseController::class, 'getLangPortuguese'])->name('lang.portuguese')->middleware('define.locale');

Route::get('/en', [BaseController::class, 'getLangEnglish'])->name('lang.english')->middleware('define.locale');

Route::get('/es', [BaseController::class, 'getLangSpanish'])->name('lang.spanish')->middleware('define.locale');


/*
 * Rotas para pesquisa de Estados e Cidades a partir do país
 */
Route::get('/get-cidades/{idEstado}', [CandidatoController::class, 'getCidades']);
Route::get('api/dependent-dropdown',[APIController::class, 'index']);
Route::get('api/get-state-list',[APIController::class, 'getStateList']);
Route::get('api/get-city-list',[APIController::class, 'getCityList']);

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

    Route::post('configura/inscricao', [ConfiguraInscricaoPosController::class, 'postConfiguraInscricao']);

    Route::get('inscricao/editar', [EditarInscricaoPosController::class, 'getEditarInscricao'])->name('editar.inscricao');

    Route::post('inscricao/editar', [EditarInscricaoPosController::class, 'postEditarInscricao']);

    Route::get('edita/usuarios', ListaUsuarios::class)->name('edita.usuarios');
});


/*
 * Rotas para as funções do coordenador
*/

Route::prefix('coordenador')->middleware(['auth', 'verified', 'user.role:coordenador,admin'])->group(function () {
    Route::get('/', [CoordenadorController::class, 'getMenu'])->name('menu.coordenador');
    Route::get('contas/coordenador/pos', [DadosCoordenadorPosController::class, 'getDadosCoordenadorPos'])->name('dados.coordenador.pos');
    Route::post('contas/coordenador/pos',[DadosCoordenadorPosController::class, 'postDadosCoordenadorPos']);
    Route::get('cadastra/area/pos', [CadastraAreaPosController::class, 'getCadastraAreaPos'])->name('cadastra.area.pos');
	Route::post('cadastra/area/pos', [CadastraAreaPosController::class,'postCadastraAreaPos']);
    Route::get('edita/area/pos', ListaAreaPos::class)->name('edita.area.pos');
    Route::get('edita/formacao', ListaFormacao::class)->name('edita.formacao');
})->name('coordenador');

/*
 * Rotas para as funções do candidato
*/

Route::prefix('candidato')->middleware(['auth', 'verified','user.role:candidato'])->group(function () {
    Route::get('/', [CandidatoController::class, 'getMenu'])->name('menu.candidato');
    Route::get('/dados/pessoais', [DadosPessoaisCandidatoController::class, 'getDadosPessoais'])->name('dados.pessoais');
    Route::get('/dados/pessoais/editar', [DadosPessoaisCandidatoController::class, 'getDadosPessoaisEditar'])->name('dados.pessoais.editar');
    Route::post('/dados/pessoais/editar', [DadosPessoaisCandidatoController::class, 'postDadosPessoaisEditar'])->name('dados.pessoais.salvar');
    Route::post('/dados/pessoais', [DadosPessoaisCandidatoController::class, 'postDadosPessoais'])->name('dados.pessoais');
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
