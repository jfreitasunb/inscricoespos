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

	Route::get('dados/escolhas', '\Posmat\Http\Controllers\CandidatoController@getEscolhaCandidato')->name('dados.escolhas');

	Route::post('dados/escolhas', '\Posmat\Http\Controllers\CandidatoController@postEscolhaCandidato');

	Route::get('motivacao/documentos', '\Posmat\Http\Controllers\CandidatoController@getMotivacaoDocumentos')->name('motivacao.documentos');

	Route::post('motivacao/documentos', '\Posmat\Http\Controllers\CandidatoController@postMotivacaoDocumentos');

	Route::get('finalizar/inscricao', '\Posmat\Http\Controllers\CandidatoController@getFinalizarInscricao')->name('finalizar.inscricao');

	Route::post('finalizar/inscricao', '\Posmat\Http\Controllers\CandidatoController@postFinalizarInscricao');

	Route::get('status/cartas', '\Posmat\Http\Controllers\CandidatoController@getStatusCartas')->name('status.cartas');

	Route::post('status/cartas', '\Posmat\Http\Controllers\CandidatoController@postStatusCartas');
});



/*
*Área do Recomendante
*/
Route::prefix('recomendante')->middleware('user.role:recomendante','define.locale')->group(function () {

	Route::get('/', '\Posmat\Http\Controllers\RecomendanteController@getMenu')->name('menu.recomendante');

	Route::get('dados/pessoais', '\Posmat\Http\Controllers\RecomendanteController@getDadosPessoaisRecomendante')->name('dados.recomendante');

	Route::get('dados/pessoais/editar', '\Posmat\Http\Controllers\RecomendanteController@getDadosPessoaisRecomendanteEditar')->name('dados.recomendante.editar');

	Route::post('dados/pessoais', '\Posmat\Http\Controllers\RecomendanteController@postDadosPessoaisRecomendante')->name('dados.recomendante.salvar');

	Route::get('cartas/pendentes', '\Posmat\Http\Controllers\RecomendanteController@getCartasPendentes')->name('cartas.pendentes');

	Route::post('cartas/pendentes', '\Posmat\Http\Controllers\RecomendanteController@postCartasPendentes');

	Route::post('carta/inicial', '\Posmat\Http\Controllers\RecomendanteController@postCartaInicial')->name('carta.inicial');

	Route::post('salva/carta/inicial', '\Posmat\Http\Controllers\RecomendanteController@postPreencherCarta')->name('salva.carta.inicial');

	Route::get('preencher/carta/final', '\Posmat\Http\Controllers\RecomendanteController@getFinalizarCarta')->name('finalizar.carta');

	Route::post('preencher/carta/final', '\Posmat\Http\Controllers\RecomendanteController@postFinalizarCarta')->name('finalizar.carta');

	Route::get('cartas/anteriores', '\Posmat\Http\Controllers\RecomendanteController@getCartasAnteriores')->name('cartas.anteriores');

	Route::get('visualiza/anteriores', '\Posmat\Http\Controllers\RecomendanteController@GeraCartasAnteriores')->name('ver.anterior');
});

/*
*Área do Admin
 */

Route::prefix('admin')->middleware('user.role:admin')->group(function () {

	Route::get('/', '\Posmat\Http\Controllers\AdminController@getMenu')->name('menu.admin');

	Route::get('contas/users/impersonate', '\Posmat\Http\Controllers\Admin\ImpersonateController@index')->name('admin.impersonate');
	
	Route::get('contas/users', 'Admin\UserController@index')->name('lista.usuarios');

	Route::get('contas/pesquisa/conta', '\Posmat\Http\Controllers\AdminController@getPesquisaConta')->name('pesquisa.usuario');

	Route::post('contas/pesquisa/conta', '\Posmat\Http\Controllers\AdminController@postPesquisaConta');

	Route::post('contas/altera/conta', '\Posmat\Http\Controllers\AdminController@postAlteraAtivaConta')->name('altera.ativa.conta');

	Route::get('contas/pesquisar/papel', '\Posmat\Http\Controllers\AdminController@getPesquisarPapelAtual')->name('pesquisar.papel');

	Route::post('contas/pesquisar/papel', '\Posmat\Http\Controllers\AdminController@postPesquisarPapelAtual');

	Route::post('contas/atribuir/papel', '\Posmat\Http\Controllers\AdminController@postAtribuirPapel');

	Route::get('contas/cria/coordenador', '\Posmat\Http\Controllers\AdminController@getCriaCoordenador')->name('criar.coordenador');

	Route::post('contas/cria/coordenador', '\Posmat\Http\Controllers\AdminController@postCriaCoordenador');

	Route::get('inscricao/editar', '\Posmat\Http\Controllers\AdminController@getEditarInscricao')->name('editar.inscricao');

	Route::post('inscricao/editar', '\Posmat\Http\Controllers\AdminController@postEditarInscricao');

	Route::get('inscricao/reativar/candidato', '\Posmat\Http\Controllers\AdminController@getReativarInscricaoCandidato')->name('reativar.candidato');

	Route::post('inscricao/pesquisa/candidato', '\Posmat\Http\Controllers\AdminController@getInscricaoParaReativar')->name('pesquisa.candidato');

	Route::get('inscricao/salvar/alteracao', '\Posmat\Http\Controllers\AdminController@getSalvaReativacao')->name('salvar.alteracao');

	Route::post('inscricao/salvar/alteracao', '\Posmat\Http\Controllers\AdminController@postReativarInscricaoCandidato');

	Route::get('inscricao/pesquisa/recomendantes', '\Posmat\Http\Controllers\AdminController@getPesquisarRecomendantes')->name('pesquisa.recomendantes');

	Route::post('inscricao/pesquisa/recomendantes', '\Posmat\Http\Controllers\AdminController@postPesquisarRecomendantes');

	Route::post('inscricao/altera/recomendante','\Posmat\Http\Controllers\AdminController@postAlteraRecomendante')->name('altera.recomendante');

	Route::get('inscricao/pesquisa/cartas/enviadas', '\Posmat\Http\Controllers\AdminController@getPesquisarCartaEnviada')->name('pesquisa.carta');

	Route::post('inscricao/pesquisa/cartas/enviadas', '\Posmat\Http\Controllers\AdminController@postPesquisarCartaEnviada');

	Route::post('inscricao/reativar/carta/enviada', '\Posmat\Http\Controllers\AdminController@postReativarCartaEnviada')->name('reativar.carta');

});

Route::resource('admin/datatable/users', 'DataTable\UserController');



/*
*Área do coordenador
 */

Route::prefix('coordenador')->middleware('user.role:coordenador,admin')->group(function () {

	Route::get('/','\Posmat\Http\Controllers\CoordenadorController@getMenu')->name('menu.coordenador');

	Route::get('cadastrar/disciplina', '\Posmat\Http\Controllers\CoordenadorController@getCadastraDisciplina')->name('cadastra.disciplina');

	Route::post('cadastrar/disciplina', '\Posmat\Http\Controllers\CoordenadorController@PostCadastraDisciplina');

	Route::get('relatorio/{id_monitoria}', '\Posmat\Http\Controllers\RelatorioController@geraRelatorio')->name('gera.relatorio');

	Route::get('relatorio', '\Posmat\Http\Controllers\RelatorioController@getListaRelatorios')->name('relatorio.atual');

	Route::get('relatorios/anteriores/{id_monitoria}', '\Posmat\Http\Controllers\RelatorioController@geraRelatoriosAnteriores')->name('gera.anteriores');

	Route::get('relatorios/anteriores', '\Posmat\Http\Controllers\RelatorioController@getListaRelatoriosAnteriores')->name('relatorio.anteriores');

	Route::get('configura/inscricao', '\Posmat\Http\Controllers\CoordenadorController@getConfiguraInscricaoPos')->name('configura.inscricao');

	Route::post('configura/inscricao', '\Posmat\Http\Controllers\CoordenadorController@postConfiguraInscricaoPos');

	Route::get('gera/ficha/individual', '\Posmat\Http\Controllers\CoordenadorController@getFichaInscricaoPorCandidato')->name('gera.ficha.individual');

	Route::get('ver/ficha/individual', '\Posmat\Http\Controllers\CoordenadorController@GeraPdfFichaIndividual')->name('ver.ficha.individual');

});



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