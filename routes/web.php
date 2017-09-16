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

/*
*Área do candidato
*/

Route::get('/aluno', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getMenu',
	'as'   => 'menu.candidato',
	'middleware' => ['user.role:aluno'],
]);

Route::get('/aluno/dados/academicos', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getDadosAcademicos',
	'as'   => 'dados.academicos',
	'middleware' => ['user.role:aluno'],
]);

Route::post('/aluno/dados/academicos', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postDadosAcademicos',
	'as'   => 'dados.academicos',
	'middleware' => ['user.role:aluno'],
]);

Route::get('/aluno/dados/bancarios', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getDadosBancarios',
	'as'   => 'dados.bancarios',
	'middleware' => ['user.role:aluno'],
]);

Route::post('/aluno/dados/bancarios', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postDadosBancarios',
	'as'   => 'dados.bancarios',
	'middleware' => ['user.role:aluno'],
]);

Route::get('/aluno/dados/pessoais', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getDadosPessoais',
	'as'   => 'dados.pessoais',
	'middleware' => ['user.role:aluno'],
]);

Route::post('/aluno/dados/pessoais', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postDadosPessoais',
	'middleware' => ['user.role:aluno'],
]);

Route::get('/aluno/dados/escolhas', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@getEscolhaCandidato',
	'as'   => 'dados.escolhas',
	'middleware' => ['user.role:aluno'],
]);

Route::post('/aluno/dados/escolhas', [
	'uses' => '\Posmat\Http\Controllers\CandidatoController@postEscolhaCandidato',
	'middleware' => ['user.role:aluno'],
]);


/*
*Área do Admin
 */

Route::get('/admin', [
	'uses' => '\Posmat\Http\Controllers\AdminController@getMenu',
	'as'   => 'menu.admin',
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
	'as' => 'relatorio.monitoria',
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
