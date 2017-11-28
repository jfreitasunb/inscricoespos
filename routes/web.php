<?php

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

Route::get('/get-cidades/{idEstado}', '\Posmat\Http\Controllers\CandidatoController@getCidades');

Route::get('api/dependent-dropdown','APIController@index');
Route::get('api/get-state-list','APIController@getStateList');
Route::get('api/get-city-list','APIController@getCityList');

/*
*Área do candidato
*/


Route::prefix('candidato')->middleware('user.role:candidato','define.locale')->group(function () {
	Route::get('/', '\Posmat\Http\Controllers\CandidatoController@getMenu')->name('menu.candidato');

	Route::get('dados/pessoais', '\Posmat\Http\Controllers\CandidatoController@getDadosPessoais')->name('dados.pessoais');

	Route::get('dados/pessoais/editar', '\Posmat\Http\Controllers\CandidatoController@getDadosPessoaisEditar')->name('dados.pessoais.editar');

	Route::post('dados/pessoais', '\Posmat\Http\Controllers\CandidatoController@postDadosPessoais')->name('dados.pessoais.salvar');

	Route::get('dados/academicos', '\Posmat\Http\Controllers\CandidatoController@getDadosAcademicos')->name('dados.academicos');

	Route::post('dados/academicos', '\Posmat\Http\Controllers\CandidatoController@postDadosAcademicos');
});



Route::get('/candidato/motivacao/documentos', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getMotivacaoDocumentos',
	'as'   => 'motivacao.documentos',
	'middleware' => ['user.role:candidato'],
]);

Route::post('/candidato/motivacao/documentos', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postMotivacaoDocumentos',
	'as'   => 'motivacao.documentos',
	'middleware' => ['user.role:candidato'],
]);

Route::get('/candidato/finalizar/inscricao', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getFinalizarInscricao',
	'as'   => 'finalizar.inscricao',
	'middleware' => ['user.role:candidato'],
]);

Route::post('/candidato/finalizar/inscricao', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postFinalizarInscricao',
	'as'   => 'finalizar.inscricao',
	'middleware' => ['user.role:candidato'],
]);



Route::get('/candidato/dados/escolhas', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getEscolhaCandidato',
	'as'   => 'dados.escolhas',
	'middleware' => ['user.role:candidato'],
]);

Route::post('/candidato/dados/escolhas', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postEscolhaCandidato',
	'as'   => 'dados.escolhas',
	'middleware' => ['user.role:candidato'],
]);

Route::get('/candidato/status/cartas', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getStatusCartas',
	'as'   => 'status.cartas',
	'middleware' => ['user.role:candidato'],
]);

Route::post('/candidato/status/cartas', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postStatusCartas',
	'as'   => 'status.cartas',
	'middleware' => ['user.role:candidato'],
]);

/*
*Área do Recomendante
*/
Route::get('/recomendante', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@getMenu',
	'as'   => 'menu.recomendante',
	'middleware' => ['user.role:recomendante','define.locale'],
]);

Route::get('/recomendante/dados/pessoais', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@getDadosPessoaisRecomendante',
	'as'   => 'dados.recomendante',
	'middleware' => ['user.role:recomendante'],
]);

Route::get('/recomendante/dados/pessoais/editar', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@getDadosPessoaisRecomendanteEditar',
	'as'   => 'dados.recomendante.editar',
	'middleware' => ['user.role:recomendante'],
]);

Route::post('/recomendante/dados/pessoais', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@postDadosPessoaisRecomendante',
	'as'   => 'dados.recomendante.salvar',
	'middleware' => ['user.role:recomendante'],
]);


Route::get('/recomendante/cartas/pendentes', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@getCartasPendentes',
	'as'   => 'cartas.pendentes',
	'middleware' => ['user.role:recomendante'],
]);

Route::post('/recomendante/cartas/pendentes', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@postCartasPendentes',
	'as'   => 'cartas.pendentes',
	'middleware' => ['user.role:recomendante'],
]);

Route::get('/recomendante/cartas/anteriores', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@getCartasAnteriores',
	'as'   => 'cartas.anteriores',
	'middleware' => ['user.role:recomendante'],
]);

Route::get('/recomendante/visualiza/anteriores', [
	'uses' => '\Posmat\Http\Controllers\RecomendanteController@GeraCartasAnteriores',
	'as'   => 'ver.anterior',
	'middleware' => ['user.role:recomendante'],
]);

Route::post('/recomendante/carta/inicial', [
		'uses'	=> '\Posmat\Http\Controllers\RecomendanteController@postCartaInicial',
		'as' => 'carta.inicial',
		'middleware' => ['user.role:recomendante'],
]);

Route::post('/recomendante/salva/carta/inicial', [
		'uses'	=> '\Posmat\Http\Controllers\RecomendanteController@postPreencherCarta',
		'as' => 'salva.carta.inicial',
		'middleware' => ['user.role:recomendante'],
]);

Route::get('/recomendante/preencher/carta/final', [
		'uses'	=> '\Posmat\Http\Controllers\RecomendanteController@getFinalizarCarta',
		'as' => 'finalizar.carta',
		'middleware' => ['user.role:recomendante'],
]);

Route::post('/recomendante/preencher/carta/final', [
		'uses'	=> '\Posmat\Http\Controllers\RecomendanteController@postFinalizarCarta',
		'as' => 'finalizar.carta',
		'middleware' => ['user.role:recomendante'],
]);

/*
*Área do Admin
 */

Route::resource('admin/datatable/users', 'DataTable\UserController');

Route::get('/admin', [
	'uses' => '\Posmat\Http\Controllers\AdminController@getMenu',
	'as'   => 'menu.admin',
	'middleware' => ['user.role:admin','define.locale'],
]);

Route::get('admin/users', [
	'uses' => 'Admin\UserController@index',
	'as' => 'lista.usuarios',
	'middleware' => ['user.role:admin','define.locale'],
]);

Route::get('/admin/ativa/conta', [
	'uses' => '\Posmat\Http\Controllers\AdminController@getAtivaConta',
	'as'   => 'ativa.conta',
	'middleware' => ['user.role:admin'],
]);

Route::post('/admin/ativa/conta', [
	'uses' => '\Posmat\Http\Controllers\AdminController@postAtivaConta',
	'as'   => 'ativa.conta',
	'middleware' => ['user.role:admin'],
]);

Route::get('/admin/pesquisar/papel', [
	'uses' => '\Posmat\Http\Controllers\AdminController@getPesquisarPapelAtual',
	'as'   => 'pesquisar.papel',
	'middleware' => ['user.role:admin'],
]);

Route::post('/admin/pesquisar/papel', [
	'uses' => '\Posmat\Http\Controllers\AdminController@postPesquisarPapelAtual',
	'as'   => 'pesquisar.papel',
	'middleware' => ['user.role:admin'],
]);

Route::post('/admin/atribuir/papel', [
	'uses' => '\Posmat\Http\Controllers\AdminController@postAtribuirPapel',
	'as'   => 'atribuir.papel',
	'middleware' => ['user.role:admin'],
]);

Route::get('/admin/cria/coordenador', [
	'uses' => '\Posmat\Http\Controllers\AdminController@getCriaCoordenador',
	'as'   => 'criar.coordenador',
	'middleware' => ['user.role:admin'],
]);

Route::post('/admin/cria/coordenador', [
	'uses' => '\Posmat\Http\Controllers\AdminController@postCriaCoordenador',
	'as'   => 'criar.coordenador',
	'middleware' => ['user.role:admin'],
]);

/*
*Área do coordenador
 */

Route::get('/coordenador/cadastrar/disciplina',[
    'uses' => '\Posmat\Http\Controllers\CoordenadorController@getCadastraDisciplina',
    'as'   => 'cadastra.disciplina',
    'middleware' => ['user.role:coordenador,admin'],
]);

Route::post('/coordenador/cadastrar/disciplina',[
    'uses' => '\Posmat\Http\Controllers\CoordenadorController@PostCadastraDisciplina',
    'as'   => 'cadastra.disciplina',
    'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador/relatorio/{id_monitoria}',[
    'uses' => '\Posmat\Http\Controllers\RelatorioController@geraRelatorio',
    'as'   => 'gera.relatorio',
    'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador/relatorio', [
	'uses' => '\Posmat\Http\Controllers\RelatorioController@getListaRelatorios',
	'as' => 'relatorio.atual',
	'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador/relatorios/anteriores/{id_monitoria}',[
    'uses' => '\Posmat\Http\Controllers\RelatorioController@geraRelatoriosAnteriores',
    'as'   => 'gera.anteriores',
    'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador/relatorios/anteriores', [
	'uses' => '\Posmat\Http\Controllers\RelatorioController@getListaRelatoriosAnteriores',
	'as' => 'relatorio.anteriores',
	'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador/configura/inscricao', [
	'uses' => '\Posmat\Http\Controllers\CoordenadorController@getConfiguraInscricaoPos',
	'as' => 'configura.inscricao',
	'middleware' => ['user.role:coordenador,admin'],
]);

Route::post('/coordenador/configura/inscricao', [
	'uses' => '\Posmat\Http\Controllers\CoordenadorController@postConfiguraInscricaoPos',
	'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador', [
	'uses' => '\Posmat\Http\Controllers\CoordenadorController@getMenu',
	'as'   => 'menu.coordenador',
	'middleware' => ['user.role:coordenador'],
]);

Route::get('/coordenador/gera/ficha/individual', [
	'uses' => '\Posmat\Http\Controllers\CoordenadorController@getFichaInscricaoPorCandidato',
	'as' => 'gera.ficha.individual',
	'middleware' => ['user.role:coordenador,admin'],
]);

Route::get('/coordenador/ver/ficha/individual', [
	'uses' => '\Posmat\Http\Controllers\CoordenadorController@GeraPdfFichaIndividual',
	'as' => 'ver.ficha.individual',
	'middleware' => ['user.role:coordenador,admin'],
]);

/**
* Logout
 */

Route::get('/logout', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getLogout',
		'as'	=> 'auth.logout',
]);

Route::post('/login', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@postLogin',
]);

/**
* Logar
 */

Route::get('/login', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getLogin',
		'as'	=> 'auth.login',
		'middleware' => ['guest', 'define.locale'],
]);

Route::post('/login', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@postLogin',
		'middleware' => ['guest', 'define.locale'],
]);

Route::get('register/verify/{token}',[
	'uses' => '\Posmat\Http\Controllers\Auth\AuthController@verify',
	'middleware' => ['guest'],
]);

/**
* Registrar
 */
Route::get('/registrar', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getSignup',
		'as'	=> 'auth.registrar',
		'middleware' => ['guest','autoriza.inscricao','define.locale']
]);

Route::post('/registrar', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@postSignup',
		'middleware' => ['guest','autoriza.inscricao','define.locale']
]);

/*
*Password Reset Routes
 */

Route::get('esqueci/senha', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm',
		'as'	=> 'password.request',
		'middleware' => ['guest'],
]);

Route::post('esqueci/senha/link', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail',
		'as' => 'password.email',
		'middleware' => ['guest'],
]);

Route::get('/esqueci/senha/{token}', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ResetPasswordController@showResetForm',
		'as' => 'password.reset',
		'middleware' => ['guest'],
]);

Route::post('/esqueci/senha/{token}', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\ResetPasswordController@reset',
		'as' => 'password.reset',
		'middleware' => ['guest'],
]);

Route::get('/mudousenha', [
		'uses'	=> '\Posmat\Http\Controllers\Auth\AuthController@getMudouSenha',
		'as'	=> 'mudou.senha',
]);

/**
* Alertas
 */
Route::get('/alert', function () {
	return redirect()->route('home')->with('info', 'Sucess.');
});

/**
* Home
 */
Route::get('/', [
		'uses'	=> '\Posmat\Http\Controllers\HomeController@index',
		'as'	=> 'home',
		'middleware' => ['define.locale'],
]);

/*
*Seleção de Idioma
*/

Route::get('/ptbr', [
	'uses' => '\Posmat\Http\Controllers\HomeController@getLangPortuguese',
	'as'   => 'lang.portuguese',
	'middleware' => ['define.locale'],
]);

Route::get('/en', [
	'uses' => '\Posmat\Http\Controllers\HomeController@getLangEnglish',
	'as'   => 'lang.english',
	'middleware' => ['define.locale'],
]);

Route::get('/es', [
	'uses' => '\Posmat\Http\Controllers\HomeController@getLangSpanish',
	'as'   => 'lang.spanish',
	'middleware' => ['define.locale'],
]);

Route::get('/migracao', [
	'uses' => '\Posmat\Http\Controllers\MigracaoController@getMigracao',
	'as'   => 'migra.dados',
	'middleware' => ['user.role:admin'],
]);