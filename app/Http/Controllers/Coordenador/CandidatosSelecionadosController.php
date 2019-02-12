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
use InscricoesPos\Models\DadoCoordenadorPos;
use InscricoesPos\Models\CandidatosSelecionados;
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
class CandidatosSelecionadosController extends CoordenadorController
{

	public function getSelecionarCandidatos()
	{
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        if ($relatorio->autoriza_homologacao()){

            $homologadas = new HomologaInscricoes;

            $inscricoes_homologadas = $homologadas->retorna_inscricoes_homologadas($id_inscricao_pos);
            
            if (sizeof($inscricoes_homologadas) == 0) {
                notify()->flash('Não há inscrições homologadas. Primeiro é necessário homologar as inscrições.','warning', [
                    'timer' => 3000,
                ]);

                return redirect()->back();
            }

            $finalizacoes = new FinalizaInscricao;

            $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->get();

            return view('templates.partials.coordenador.seleciona_candidatos');
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível fazer a seleção dos candidatos.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
      }
	}

    public function postSelecinarCandidatos(Request $request)
    {
        $user = Auth::user();

        $id_user = $user->id_user;

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        if ($relatorio->autoriza_inscricao()) {
            
            notify()->flash('As inscrições não terminaram ainda. Não é informar os candidatos selecionados.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }

        $this->validate($request, [
            'selecionar' => 'required',
        ]);

        $homologacoes = new HomologaInscricoes();

        $lista_homologacoes = $homologacoes->retorna_inscricoes_homologadas($id_inscricao_pos);

        if (sizeof($lista_homologacoes) == 0) {
            
            notify()->flash('As inscrições não foram homologadas ainda. Homologue as inscrições para poder informar os candidatos selecionados.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }

        $limpa_homologacoes = new CandidatosSelecionados();

        $limpa_homologacoes->limpa_selecoes_anteriores($id_inscricao_pos);

        foreach ($request->selecionar as $id => $selecionar) {
            
            $homologa = new CandidatosSelecionados();

            $homologa->id_candidato = $id;

            $homologa->id_inscricao_pos = $id_inscricao_pos;

            $homologa->programa_pretendido = explode("_", $selecionar)[1];

            $homologa->selecionado = explode("_", $selecionar)[0];

            $homologa->id_coordenador = $id_user;

            $homologa->save();
        }

        notify()->flash('Dados salvos com sucesso.','success', [
            'timer' => 2000,
        ]);

        return redirect()->back();
    }



    public function postCandidadosSelecionados()
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

        $local_arquivo_selecionados = storage_path("app/public/relatorios/edital_".$edital."/");

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $dados_homologacao['edital'] = str_pad(explode("-",$relatorio_disponivel->edital)[1], 2, '0', STR_PAD_LEFT)."/".explode("-",$relatorio_disponivel->edital)[0];

        $numero_programas = count(explode("_", $relatorio_disponivel->programa));

        if ($numero_programas > 1) {
            $dados_homologacao['texto_cursos_pos'] = "os cursos de Mestrado Acadêmico e Doutorado";
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

        $homologa = new CandidatosSelecionados;

        $inscricoes_homologadas = $homologa->retorna_candidatos_selecionados($id_inscricao_pos);

        $programas = explode("_", $relatorio_disponivel->programa);

        foreach ($programas as $programa) {
            
            foreach ($inscricoes_homologadas as $homologada) {
                if ($homologada->programa_pretendido == $programa) {
                    $homologacoes[(new ProgramaPos())->pega_programa_pos_mat($programa, $locale)][] = $this->titleCase(User::find($homologada->id_candidato)->nome);
                }
                
            }
        }

        ksort($homologacoes);

        $dados_homologacao['dia'] = Carbon::now()->day;

        $dados_homologacao['nome_mes'] = $this->array_meses[Carbon::now()->month];

        $dados_homologacao['ano_homologacao'] = Carbon::now()->year;

        $dados_homologacao['nome_coordenador'] = explode("_", $dados_coordenador->tratamento)[0]." ".$dados_coordenador->nome_coordenador;

        $dados_homologacao['tratamento'] = explode("_", $dados_coordenador->tratamento)[1];
        
        $pdf = PDF::loadView('templates.partials.coordenador.pdf_candidatos_selecionados', compact('homologacoes', 'dados_homologacao'));
        $nome_arquivo_homologacao = "Candidados_Selecionados_Edital-".$edital.".pdf";

        $pdf->save($local_arquivo_selecionados.$nome_arquivo_homologacao);

        return Response::download($local_arquivo_selecionados.$nome_arquivo_homologacao, $nome_arquivo_homologacao);
        
    }
}