<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use Purifier;
use PDF;
use Posmat\Http\Controllers\FPDFController;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Paises;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\Cidade;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\DadoAcademico;
use Posmat\Models\Documento;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPos;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;
use League\Csv\Writer;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use UrlSigner;

/**
* Classe para visualização da página inicial.
*/
class MigracaoController extends BaseController
{
  public function getMigracao()
  {
        // // Migra usuários para novo sistema

        // $users = DB::connection('pos2')->table('users')->orderBy('id_user', 'asc')->get();

        // foreach ($users as $user) {
        //     $users_candidato = DB::connection('pos2')->table('dados_pessoais')->where('id_user', $user->id_user)->first();
            
        //     $novo_usuario = new User();
            
        //     if (!is_null($users_candidato)) {
        //         $novo_usuario->nome = $users_candidato->nome;
        //     }
        //     $novo_usuario->id_user = $user->id_user;
        //     $novo_usuario->email = Purifier::clean(strtolower(trim($user->email)));
        //     $novo_usuario->locale = $user->locale;
        //     $novo_usuario->password = $user->password;
        //     $novo_usuario->validation_code = null;
        //     $novo_usuario->user_type = $user->user_type;
        //     $novo_usuario->ativo = $user->ativo;
        //     $novo_usuario->remember_token = null;
        //     $novo_usuario->created_at = $user->created_at;
        //     $novo_usuario->updated_at = $user->updated_at;
        //     $novo_usuario->save(); 
        // }
        
        // //Fim da migração dos usuário para o novo sistema

        // //Migra área da Pós para o novo sistema

        // $areas_pos = DB::connection('pos2')->table('area_pos_mat')->orderBy('id_area_pos','asc')->get();

        // foreach ($areas_pos as $area) {
        //     $nova_area = new AreaPosMat();

        //     $nova_area->id_area_pos = $area->id_area_pos;
        //     $nova_area->nome_ptbr = $area->nome;
        //     $nova_area->nome_en = $area->nome_en;
        //     $nova_area->nome_es = $area->nome_es;
        //     $nova_area->created_at = $area->created_at;
        //     $nova_area->updated_at = $area->updated_at;
        //     $nova_area->save();
        // }
        

        // //Fim da Migração das áreas da Pós  para o novo sistema
        
        // // //Migra as formaçoes para o novo sistema

        // $formacoes = DB::connection('pos2')->table('formacao')->orderBy('id','asc')->get();

        // foreach ($formacoes as $formacao) {
        //     $nova_formacao = new Formacao();
        //     $nova_formacao->tipo_ptbr = $formacao->tipo;
        //     $nova_formacao->tipo_en = $formacao->tipo_en;
        //     $nova_formacao->tipo_es = $formacao->tipo_es;
        //     $nova_formacao->nivel = $formacao->nivel;
        //     $nova_formacao->created_at = $formacao->created_at;
        //     $nova_formacao->updated_at = $formacao->updated_at;
        //     $nova_formacao->save();
        // }

        // // // //Fim da migração das formacoes para o novo sistema

        // // // //Migra programas da Pós para o novo sistema.

        // $programas_pos = DB::connection('pos2')->table('programa_pos_mat')->orderBy('id_programa_pos','asc')->get();

        // foreach ($programas_pos as $programa_pos) {
            
        //     $novo_programa_pos = new ProgramaPos();

        //     $novo_programa_pos->id_programa_pos = $programa_pos->id_programa_pos;
        //     $novo_programa_pos->tipo_programa_pos_ptbr = $programa_pos->tipo_programa_pos;
        //     $novo_programa_pos->tipo_programa_pos_en = $programa_pos->tipo_programa_pos_en;
        //     $novo_programa_pos->tipo_programa_pos_es = $programa_pos->tipo_programa_pos_es;
        //     $novo_programa_pos->created_at = $programa_pos->created_at;
        //     $novo_programa_pos->updated_at = $programa_pos->updated_at;
        //     $novo_programa_pos->save();
        // }
        

        // // //Fim da migração dos programas da Pós para o novo sistema.

        // //Migra as inscrições já configuradas para o novo sistema

        // $inscricoes_configuradas = DB::connection('pos2')->table('configura_inscricao_pos')->orderBy('id_inscricao_pos','asc')->get();

        // foreach ($inscricoes_configuradas as $inscricao) {
            
        //     $nova_inscricao_configurada = new ConfiguraInscricaoPos();

        //     $nova_inscricao_configurada->id_inscricao_pos = $inscricao->id_inscricao_pos;
        //     $nova_inscricao_configurada->inicio_inscricao = $inscricao->inicio_inscricao;
        //     $nova_inscricao_configurada->fim_inscricao = $inscricao->fim_inscricao;
        //     $nova_inscricao_configurada->prazo_carta = $inscricao->prazo_carta;
        //     $nova_inscricao_configurada->programa = $inscricao->programa;
        //     $nova_inscricao_configurada->edital = $inscricao->edital;
        //     $nova_inscricao_configurada->id_coordenador = $inscricao->id_coordenador;
        //     $nova_inscricao_configurada->created_at = $inscricao->created_at;
        //     $nova_inscricao_configurada->updated_at = $inscricao->updated_at;
        //     $nova_inscricao_configurada->save();
        // }
        

        // // //Fim da migração das inscrições já configuradas para o novo sistema.

        // // // //Migra os arquivos enviados pelo candidatos

        // $arquivos_enviados = DB::connection('pos2')->table('arquivos_enviados')->orderBy('id','asc')->get();

        // foreach ($arquivos_enviados as $arquivo) {

        //     $novo_arquivos_enviados = new Documento();

        //     $novo_arquivos_enviados->id = $arquivo->id;
        //     $novo_arquivos_enviados->id_candidato = $arquivo->id_user;
        //     $novo_arquivos_enviados->nome_arquivo = $arquivo->nome_arquivo;
        //     $novo_arquivos_enviados->tipo_arquivo = $arquivo->tipo_arquivo;
        //     $novo_arquivos_enviados->id_inscricao_pos = $arquivo->id_inscricao_pos;
        //     $novo_arquivos_enviados->created_at = $arquivo->created_at;
        //     $novo_arquivos_enviados->updated_at = $arquivo->updated_at;
        //     $novo_arquivos_enviados->save();
        // }

        // // //Fim da migração dos arquivos enviados pelo candidatos

        // // //Migra as cartas de motivação dos candidatos

        // $carta_motivacao = DB::connection('pos2')->table('carta_motivacoes')->orderBy('id','asc')->get();


        // foreach ($carta_motivacao as $motivacao) {
            

        //     $nova_carta_motivacao = new CartaMotivacao();

        //     $nova_carta_motivacao->id = $motivacao->id;
        //     $nova_carta_motivacao->id_candidato = $motivacao->id_user;
        //     $nova_carta_motivacao->motivacao = $motivacao->motivacao;
        //     $nova_carta_motivacao->concorda_termos = $motivacao->concorda_termos;
        //     $nova_carta_motivacao->id_inscricao_pos = $motivacao->id_inscricao_pos;
        //     $nova_carta_motivacao->created_at = $motivacao->created_at;
        //     $nova_carta_motivacao->updated_at = $motivacao->updated_at;
        //     $nova_carta_motivacao->save();

        // }

        // // //Fim da migração das cartas de motivação dos candidatos

        // //Migra os contatos dos recomendantes

        // $recomendantes_indicados = DB::connection('pos2')->table('contatos_recomendantes')->orderBy('id','asc')->get();

        // foreach ($recomendantes_indicados as $recomendante) {
            
        //     $novo_contatos_recomendante = new ContatoRecomendante();

        //     $novo_contatos_recomendante->id = $recomendante->id;
        //     $novo_contatos_recomendante->id_candidato = $recomendante->id_user;
        //     $novo_contatos_recomendante->id_recomendante = $recomendante->id_recomendante;
        //     $novo_contatos_recomendante->id_inscricao_pos = $recomendante->id_inscricao_pos;
        //     $novo_contatos_recomendante->email_enviado = $recomendante->email_enviado;
        //     $novo_contatos_recomendante->created_at = $recomendante->created_at;
        //     $novo_contatos_recomendante->updated_at = $recomendante->updated_at;
        //     $novo_contatos_recomendante->save();
            
        // }
        // //Fim da migração dos contatos dos recomendantes
        
        // // //Início da migração dos dados acadêmicos do candidato
        
        // $dados_academicos_candidato = DB::connection('pos2')->table('dados_academicos')->orderBy('id','asc')->get();


        // foreach ($dados_academicos_candidato as $academico_candidato) {

        //     $novo_dados_academicos_candidato = new DadoAcademico();

        //     $novo_dados_academicos_candidato->id = $academico_candidato->id;
        //     $novo_dados_academicos_candidato->id_candidato = $academico_candidato->id_user;
        //     $novo_dados_academicos_candidato->curso_graduacao = $academico_candidato->curso_graduacao;
        //     $novo_dados_academicos_candidato->tipo_curso_graduacao = $academico_candidato->tipo_curso_graduacao;
        //     $novo_dados_academicos_candidato->instituicao_graduacao = $academico_candidato->instituicao_graduacao;
        //     $novo_dados_academicos_candidato->ano_conclusao_graduacao = $academico_candidato->ano_conclusao_graduacao;
        //     $novo_dados_academicos_candidato->curso_pos = $academico_candidato->curso_pos;
        //     if ($academico_candidato->tipo_curso_pos == 0) {
        //         $novo_dados_academicos_candidato->tipo_curso_pos = 9;
        //     }else{
        //         $novo_dados_academicos_candidato->tipo_curso_pos = $academico_candidato->tipo_curso_pos;
        //     }
        //     $novo_dados_academicos_candidato->instituicao_pos = $academico_candidato->instituicao_pos;
        //     $novo_dados_academicos_candidato->ano_conclusao_pos = $academico_candidato->ano_conclusao_pos;
        //     $novo_dados_academicos_candidato->created_at = $academico_candidato->created_at;
        //     $novo_dados_academicos_candidato->updated_at = $academico_candidato->updated_at;
        //     $novo_dados_academicos_candidato->save();

        // }

        // // //Fim da migração dos dados acadêmicos do candidato


        // //Início da migração dos dados pessoais do candidato
            $users = DB::connection('pos2')->table('dados_pessoais')->where('id_user','>',2)->orderBy('id_user', 'asc')->get();

            foreach ($users as $user) {
                
                $novo_dado_pessoal_candidato = new DadoPessoal();

                $novo_dado_pessoal_candidato->id_candidato = $user->id_user;
                $novo_dado_pessoal_candidato->data_nascimento = $user->data_nascimento;
                $novo_dado_pessoal_candidato->numerorg = $user->numerorg;
                $novo_dado_pessoal_candidato->endereco = $user->endereco;
                $novo_dado_pessoal_candidato->cep = $user->cep;
                $novo_dado_pessoal_candidato->pais = $user->pais;
                $novo_dado_pessoal_candidato->estado = $user->estado;
                $novo_dado_pessoal_candidato->cidade = $user->cidade;
                $novo_dado_pessoal_candidato->celular = $user->celular;
                $novo_dado_pessoal_candidato->created_at = $user->created_at;
                $novo_dado_pessoal_candidato->updated_at = $user->updated_at;
                $novo_dado_pessoal_candidato->save();

            }


        // //Fim da migração dos dados pessoais do candidato
  }
}