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
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\DadoCoordenadorPos;
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
use Response;
/**
* Classe para visualização da página inicial.
*/
class AcessaDocumentosMatriculaController extends CoordenadorController
{

    public function index()
    {
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $finalizacoes = new FinalizaInscricao;

        if ($relatorio->autoriza_homologacao()){

            return view('templates.partials.coordenador.acessa_documentos_matricula');    
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
    }

	public function getHomologarInscritos()
	{
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $finalizacoes = new FinalizaInscricao;

        if ($relatorio->autoriza_homologacao()){

            $inscricoes_homologadas = new HomologaInscricoes();

            $ja_homologou = $inscricoes_homologadas->retorna_inscricoes_homologadas($id_inscricao_pos);

            if (sizeof($ja_homologou) > 0) {
                
                notify()->flash('As inscrições já foram homologadas. Não é possível homologar novamente.','warning', [
                    'timer' => 3000,
                ]);

                return redirect()->back();
            }
            
            $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($id_inscricao_pos, $this->locale_default)->get();

            return view('templates.partials.coordenador.acessa_documentos_matricula', compact('relatorio_disponivel','inscricoes_finalizadas'));    
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
        
	}

    public function postHomologarInscritos()
    {

        $user = Auth::user();

        $id_user = $user->id_user;

        $locale = "pt-br";

        $coordenador = new DadoCoordenadorPos();

        $dados_coordenador = $coordenador->retorna_dados_coordenador_atual();

        $dados_homologacao = [];

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $edital = $relatorio_disponivel->edital;

        $local_arquivo_homologacoes = storage_path("app/public/relatorios/edital_".$edital."/");

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $dados_homologacao['edital'] = str_pad(explode("-",$relatorio_disponivel->edital)[1], 2, '0', STR_PAD_LEFT)."/".explode("-",$relatorio_disponivel->edital)[0];

        $numero_programas = count(explode("_", $relatorio_disponivel->programa));

        if ($numero_programas > 1) {
            $dados_homologacao['texto_cursos_pos'] = "os cursos de Doutorado e Mestrado Acadêmico";
        }else{
            if ($relatorio_disponivel->programa == 1) {
                $dados_homologacao['texto_cursos_pos'] = "o curso de ".(new ProgramaPos())->pega_programa_pos_mat($relatorio_disponivel->programa, $locale)."Acadêmico";
            }else{
                $dados_homologacao['texto_cursos_pos'] = "o curso de ".(new ProgramaPos())->pega_programa_pos_mat($relatorio_disponivel->programa, $locale);
            }
            
        }

        $mes_fim_inscricao = explode("-", $relatorio_disponivel->fim_inscricao)[1];

        if ($mes_fim_inscricao >= 6) {
            $dados_homologacao['texto_semestre'] = 'primeiro';
            $dados_homologacao['numero_semestre'] = 1;
            $dados_homologacao['ano_inicio'] = explode("-", $relatorio_disponivel->fim_inscricao)[0] + 1;
        }else{
            $dados_homologacao['texto_semestre'] = 'segundo';
            $dados_homologacao['numero_semestre'] = 2;
            $dados_homologacao['ano_inicio'] = explode("-", $relatorio_disponivel->fim_inscricao)[0];
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
        
        $dados_homologacao['dia'] = explode("-",$relatorio_disponivel->data_homologacao)[2];

        $dados_homologacao['nome_mes'] = $this->array_meses[str_replace("0", "", explode("-",$relatorio_disponivel->data_homologacao)[1])];

        $dados_homologacao['ano_homologacao'] = explode("-",$relatorio_disponivel->data_homologacao)[0];

        $dados_homologacao['nome_coordenador'] = explode("_", $dados_coordenador->tratamento)[0]." ".$dados_coordenador->nome_coordenador;

        $dados_homologacao['tratamento'] = explode("_", $dados_coordenador->tratamento)[1];
        
        $pdf = PDF::loadView('templates.partials.coordenador.pdf_homologacoes', compact('homologacoes', 'dados_homologacao'));
        $nome_arquivo_homologacao = "Homologacao-".$dados_homologacao['ano_inicio']."-".$dados_homologacao['numero_semestre'].".pdf";

        $pdf->save($local_arquivo_homologacoes.$nome_arquivo_homologacao);

        return Response::download($local_arquivo_homologacoes.$nome_arquivo_homologacao, $nome_arquivo_homologacao);
        
    }
}