<?php

namespace InscricoesPos\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\AssociaEmailsRecomendante;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DadoPessoalCandidato;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademico;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoPessoalRecomendante;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\Documento;
use InscricoesPos\Models\Paises;
use InscricoesPos\Models\CandidatosSelecionados;
use InscricoesPos\Models\Cidade;
use InscricoesPos\Notifications\NotificaRecomendante;
use InscricoesPos\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class CandidatoController extends BaseController
{

	private $estadoModel;

    public function __construct(Estado $estado)
    {
        $this->estadoModel = $estado;
    }

    public function getCidades($idEstado)
    {
        $estado = $this->estadoModel->find($idEstado);
        
        $cidades = $estado->cidades()->getQuery()->get(['id', 'cidade']);
        
        return Response::json($cidades);
    }

	public function getMenu()
	{	
	
    	Session::get('locale');
        
        $user = $this->SetUser();
        
        $id_user = $user->id_user;

        $edital_ativo = new ConfiguraInscricaoPos();

        $id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;

        $selecionado = new CandidatosSelecionados();

        $status_selecao = $selecionado->retorna_status_selecionado($id_inscricao_pos, $id_user);

        if (!is_null($status_selecao)) {
    
            if ($status_selecao->selecionado AND !$status_selecao->confirmou_presenca) {
    
                return redirect()->route('confirma.presenca');
            }
        }
        
		return view('home');
	}

    public function getVerEditalVigente()
    {
        Session::get('locale');
        
        $user = $this->SetUser();
        
        $id_candidato = $user->id_user;

        $locale_candidato = User::find($id_candidato)->locale;

        $edital_vigente = new ConfiguraInscricaoPos();

        $edital = $edital_vigente->retorna_inscricao_ativa()->edital;

        $arquivos_editais = "storage/editais/";

        $edital_pdf = 'Edital_MAT_'.$edital.'_ptbr';

        if ($locale_candidato == 'en' && file_exists(storage_path("app/public/editais/").'Edital_MAT_'.$edital.'_en.pdf') ) {
            $edital_pdf = 'Edital_MAT_'.$edital.'_en';
        }
        
        if ($locale_candidato == 'es' && file_exists(storage_path("app/public/editais/").'Edital_MAT_'.$edital.'_es.pdf') ) {
            $edital_pdf = 'Edital_MAT_'.$edital.'_es';
        }

        return view('templates.partials.candidato.ver_edital_vigente',compact('arquivos_editais', 'edital', 'edital_pdf'));

    }
}
