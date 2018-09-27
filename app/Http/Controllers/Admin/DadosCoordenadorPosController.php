<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use Session;
use InscricoesPos\Models\{User, DadosCoordenadorPos};
use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CoordenadorController;
use InscricoesPos\Http\Controllers\DataTable\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class DadosCoordenadorPosController extends AdminController
{

	public function getDadosCoordenadorPos()
	{

      	return view('templates.partials.admin.dados_coordenador_pos');
	}

	public function postDadosCoordenadorPos(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao',
			'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'data_homologacao' => 'required|date_format:"Y-m-d"|after:fim_inscricao',
			'data_divulgacao_resultado' => 'required|date_format:"Y-m-d"|after:data_homologacao',
			'edital' => 'required',
			'programa' => 'required',
		]);

		$edital_vigente = ConfiguraInscricaoPos::find((int)$request->id_inscricao_pos);

		$novos_dados_edital['inicio_inscricao'] = $request->inicio_inscricao;
		$novos_dados_edital['fim_inscricao'] = $request->fim_inscricao;
		$novos_dados_edital['prazo_carta'] = $request->prazo_carta;
		$novos_dados_edital['programa'] = $request->programa;
		$novos_dados_edital['edital'] = $request->edital;
		$novos_dados_edital['data_homologacao'] = $request->data_homologacao;
		$novos_dados_edital['data_divulgacao_resultado'] = $request->data_divulgacao_resultado;

		$edital_vigente->update($novos_dados_edital);

		notify()->flash('Inscrição alterada com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('editar.inscricao');
	}
}