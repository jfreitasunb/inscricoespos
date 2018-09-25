<?php

namespace InscricoesPos\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\RelatorioController;
use Illuminate\Foundation\Auth\RegistersUsers;
use UrlSigner;
use URL;

/**
* Classe para visualização da página inicial.
*/
class HomologaInscricoesController extends CoordenadorController
{

	public function getHomologarInscritos()
	{
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $finalizacoes = new FinalizaInscricao;

        if ($relatorio->autoriza_homologacao()){
            $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->get();

            return view('templates.partials.coordenador.homologa_inscricoes', compact('relatorio_disponivel','inscricoes_finalizadas'));    
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
        
	}

    public function postHomologarInscritos(Request $request)
    {
        $user = Auth::user();

        $id_user = $user->id_user;

        $locale = "pt-br";

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        if ($relatorio->autoriza_inscricao()) {
            
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
        
        $this->validate($request, [
            'homologar' => 'required',
        ]);
        
        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        $limpa_homologacoes = new HomologaInscricoes();

        $limpa_homologacoes->limpa_homologacoes_anteriores($id_inscricao_pos);

        foreach ($request->homologar as $id => $homologar) {
            
            $homologa = new HomologaInscricoes();

            $homologa->id_candidato = $id;

            $homologa->id_inscricao_pos = $id_inscricao_pos;

            $homologa->programa_pretendido = explode("_", $homologar)[1];

            $homologa->homologada = explode("_", $homologar)[0];

            $homologa->id_coordenador = $id_user;

            $homologa->save();
        }

        notify()->flash('Dados salvos com sucesso.','success', [
            'timer' => 2000,
        ]);

        $edital = str_pad(explode("-",$relatorio_disponivel->edital)[1], 2, '0', STR_PAD_LEFT)."/".explode("-",$relatorio_disponivel->edital)[0];

        $numero_programas = count(explode("_", $relatorio_disponivel->programa));

        if ($numero_programas > 1) {
            $texto_cursos_pos = "os cursos de Doutorado e Mestrado Acadêmico";
        }else{
            if ($relatorio_disponivel->programa == 1) {
                $texto_cursos_pos = "o curso de ".(new ProgramaPos())->pega_programa_pos_mat($relatorio_disponivel->programa, $locale)."Acadêmico";
            }else{
                $texto_cursos_pos = "o curso de ".(new ProgramaPos())->pega_programa_pos_mat($relatorio_disponivel->programa, $locale);
            }
            
        }

        $mes_fim_inscricao = explode("-", $relatorio_disponivel->fim_inscricao)[1];

        if ($mes_fim_inscricao >= 6) {
            $texto_semestre = 'primeiro';
            $numero_semestre = 1;
            $ano = explode("-", $relatorio_disponivel->fim_inscricao)[0] + 1;
        }else{
            $texto_semestre = 'segundo';
            $numero_semestre = 2;
            $ano = explode("-", $relatorio_disponivel->fim_inscricao)[0];
        }

        $homologa = new HomologaInscricoes;

        $inscricoes_homologadas = $homologa->retorna_inscricoes_homologadas($id_inscricao_pos);

        $programas = explode("_", $relatorio_disponivel->programa);

        foreach ($programas as $programa) {
            
            foreach ($inscricoes_homologadas as $homologada) {
                if ($homologada->programa_pretendido == $programa) {
                    $homologacoes[(new ProgramaPos())->pega_programa_pos_mat($programa, $locale)][] = $this->titleCase(User::find($homologada->id_candidato)->nome);
                }
                
            }
        }
        asort($homologacoes);
        
        $dados_homologacao = [];
        
        $dados_homologacao['dia'] = explode("-",$relatorio_disponivel->data_homologacao)[2];

        $dados_homologacao['nome_mes'] = $this->array_meses[str_replace("0", "", explode("-",$relatorio_disponivel->data_homologacao)[1])];

        $dados_homologacao['ano_homologacao'] = explode("-",$relatorio_disponivel->data_homologacao)[0];

        $pdf = PDF::loadView('templates.partials.coordenador.pdf_homologacoes', compact('edital', 'texto_cursos_pos', 'texto_semestre', 'numero_semestre', 'ano', 'homologacoes', 'dados_homologacao'));
        
        return $pdf->stream();
        
        // return redirect()->back();
    }
}