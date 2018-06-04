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
        
        // //Migra as formaçoes para o novo sistema

        $formacoes = DB::connection('pos2')->table('formacao')->orderBy('id','asc')->get();

        foreach ($formacoes as $formacao) {
            $nova_formacao = new Formacao();
            $nova_formacao->tipo_ptbr = $formacao->tipo;
            $nova_formacao->tipo_en = $formacao->tipo_en;
            $nova_formacao->tipo_es = $formacao->tipo_es;
            $nova_formacao->nivel = $formacao->nivel;
            $nova_formacao->created_at = $formacao->created_at;
            $nova_formacao->updated_at = $formacao->updated_at;
            $nova_formacao->save();
        }

        // // //Fim da migração das formacoes para o novo sistema

        // // // //Migra dados acadêmicos dos candidatos para o novo sistema.

        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // foreach ($users_candidato as $candidato) {

        //     $dados_academicos_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_profissionais_candidato')->where('id_aluno', $candidato->coduser)->first();

             
        //     if (!is_null($dados_academicos_antigos_usuario)) {
                
        //         $novo_usuario = new User();

        //         $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //         $novos_dados_academicos = new DadoAcademico();

        //         $existe_dados_academicos = $novos_dados_academicos->retorna_dados_academicos($novo_id_usuario);

        //         if (is_null($existe_dados_academicos)) {

        //             $novos_dados_academicos->id_user = $novo_id_usuario;

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'bacharel') {
                        
        //                 $novos_dados_academicos->tipo_curso_graduacao = 1;

        //                 $novos_dados_academicos->curso_graduacao = trim($dados_academicos_antigos_usuario->instrucaocurso);

        //                 $novos_dados_academicos->instituicao_graduacao = trim($dados_academicos_antigos_usuario->instrucaoinstituicao);

        //                 $novos_dados_academicos->ano_conclusao_graduacao = trim($dados_academicos_antigos_usuario->instrucaoanoconclusao);
        //             }

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'licenciado') {
                        
        //                 $novos_dados_academicos->tipo_curso_graduacao = 2;

        //                 $novos_dados_academicos->curso_graduacao = trim($dados_academicos_antigos_usuario->instrucaocurso);

        //                 $novos_dados_academicos->instituicao_graduacao = trim($dados_academicos_antigos_usuario->instrucaoinstituicao);

        //                 $novos_dados_academicos->ano_conclusao_graduacao = trim($dados_academicos_antigos_usuario->instrucaoanoconclusao);
        //             }


        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'mestre' or $dados_academicos_antigos_usuario->instrucaograu == 'especialista') {
                        
        //                 $novos_dados_academicos->tipo_curso_pos = 5;
        //                 $novos_dados_academicos->curso_pos = trim($dados_academicos_antigos_usuario->instrucaocurso);

        //                 $novos_dados_academicos->instituicao_pos = trim($dados_academicos_antigos_usuario->instrucaoinstituicao);

        //                 $novos_dados_academicos->ano_conclusao_pos = trim($dados_academicos_antigos_usuario->instrucaoanoconclusao);
        //             }

        //             $novos_dados_academicos->save();

        //         }else{

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'bacharel') {
                        
        //                 $atualiza_dados_pessoais['tipo_curso_graduacao'] = 1;

        //                 $atualiza_dados_pessoais['curso_graduacao'] = trim($dados_academicos_antigos_usuario->instrucaocurso);

        //                 $atualiza_dados_pessoais['instituicao_graduacao'] = trim($dados_academicos_antigos_usuario->instrucaoinstituicao);

        //                 $atualiza_dados_pessoais['ano_conclusao_graduacao'] = trim($dados_academicos_antigos_usuario->instrucaoanoconclusao);
        //             }

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'licenciado') {
                        
        //                 $atualiza_dados_pessoais['tipo_curso_graduacao'] = 2;

        //                 $atualiza_dados_pessoais['curso_graduacao'] = trim($dados_academicos_antigos_usuario->instrucaocurso);

        //                 $atualiza_dados_pessoais['instituicao_graduacao'] = trim($dados_academicos_antigos_usuario->instrucaoinstituicao);

        //                 $atualiza_dados_pessoais['ano_conclusao_graduacao'] = trim($dados_academicos_antigos_usuario->instrucaoanoconclusao);
        //             }

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'outro') {
                        
        //                 $atualiza_dados_pessoais['tipo_curso_graduacao'] = 7;
        //             }

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'mestre' or $dados_academicos_antigos_usuario->instrucaograu == 'especialista') {
                        
        //                 $atualiza_dados_pessoais['tipo_curso_pos'] = 5;
        //                 $atualiza_dados_pessoais['curso_pos'] = trim($dados_academicos_antigos_usuario->instrucaocurso);

        //                 $atualiza_dados_pessoais['instituicao_pos'] = trim($dados_academicos_antigos_usuario->instrucaoinstituicao);

        //                 $atualiza_dados_pessoais['ano_conclusao_pos'] = trim($dados_academicos_antigos_usuario->instrucaoanoconclusao);
        //             }

        //             if ($dados_academicos_antigos_usuario->instrucaograu == 'outro') {
                        
        //                 $atualiza_dados_pessoais['tipo_curso_pos'] = 8;   
        //             }

        //             $existe_dados_academicos->update($atualiza_dados_pessoais);
        //         }            
        //     }
        // }

        // // //Fim da migração dos dados acadêmicos dos candidatos para o novo sistema.

        // // //Migra documentos para o novo sistema

        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // $inscricoes_configuradas = ConfiguraInscricaoPos::all();


        // foreach ($users_candidato as $candidato) {

        //     $documentos_candidato = DB::connection('pos2')->table('inscricao_pos_anexos')->where('coduser', $candidato->coduser)->where('tipo', 'documentos')->get();


        //     $historicos_candidato = DB::connection('pos2')->table('inscricao_pos_anexos')->where('coduser', $candidato->coduser)->where('tipo', 'historico')->get();

        //     $novo_usuario = new User();

        //     $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //     foreach ($documentos_candidato as $documento_enviado) {

        //         if (File::exists(public_path('uploads_temporario/').$documento_enviado->nome_arquivo)) {
                    
        //             $documento = new Documento();

        //             $documento->id_user = $novo_id_usuario;

        //             foreach ($inscricoes_configuradas as $inscricao) {
                    
        //                 if ($documento_enviado->data >= $inscricao->inicio_inscricao and $documento_enviado->data <= $inscricao->fim_inscricao ) {
                            
        //                     $documento->id_inscricao_pos = $inscricao->id_inscricao_pos;
        //                 }
        //             }

        //             if (is_null($documento->id_inscricao_pos)) {
        //                 $documento->id_inscricao_pos = 0;
        //             }

        //             $nome_crypt_arquivo = md5_file(public_path('uploads_temporario/').$documento_enviado->nome_arquivo);

        //             $doc_pessoais = File::copy(public_path('uploads_temporario/').$documento_enviado->nome_arquivo,storage_path('app/').'uploads/'.$nome_crypt_arquivo.'.'.File::extension($documento_enviado->nome_arquivo));

        //             $documento->nome_arquivo = 'uploads/'.$nome_crypt_arquivo.'.'.File::extension($documento_enviado->nome_arquivo);

        //             $documento->tipo_arquivo = 'Documentos';

        //             $documento->created_at = $documento_enviado->data.mt_rand(1, 24).':'.mt_rand(10, 60).':'.mt_rand(10, 60);

        //             $documento->save();
        //         }

                
        //     }

        //     foreach ($historicos_candidato as $historico_enviado) {

        //         if (File::exists(public_path('uploads_temporario/').$historico_enviado->nome_arquivo)) {
                    
        //             $nome_crypt_historico = md5_file(public_path('uploads_temporario/').$historico_enviado->nome_arquivo);
                    
        //             $documento = new Documento();

        //             $documento->id_user = $novo_id_usuario;

        //             foreach ($inscricoes_configuradas as $inscricao) {
                    
        //                 if ($historico_enviado->data >= $inscricao->inicio_inscricao and $historico_enviado->data <= $inscricao->fim_inscricao ) {
                            
        //                     $documento->id_inscricao_pos = $inscricao->id_inscricao_pos;
        //                 }
        //             }

        //             if (is_null($documento->id_inscricao_pos)) {
        //                 $documento->id_inscricao_pos = 0;
        //             }

        //             $historico_pessoais = File::copy(public_path('uploads_temporario/').$historico_enviado->nome_arquivo,storage_path('app/').'uploads/'.$nome_crypt_historico.'.'.File::extension($historico_enviado->nome_arquivo));

        //             $documento->nome_arquivo = 'uploads/'.$nome_crypt_historico.'.'.File::extension($historico_enviado->nome_arquivo);

        //             $documento->tipo_arquivo = 'Histórico';

        //             $documento->created_at = $historico_enviado->data.mt_rand(1, 24).':'.mt_rand(10, 60).':'.mt_rand(10, 60);

        //             $documento->save();
        //         }
        //     }
            
        // }

        // // // //Fim da migração dos documentos para o novo sistema.

        // // // //Migra as cartas de motivação dos candidatos

        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // $inscricoes_configuradas = ConfiguraInscricaoPos::all();

        // foreach ($users_candidato as $candidato) {
            
        //     $motivacao_candidato = DB::connection('pos2')->table('inscricao_pos_carta_motivacao')->where('id_aluno', $candidato->coduser)->orderBy('edital', 'asc')->get()->all();

        //     $novo_usuario = new User();

        //     $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //     foreach ($motivacao_candidato as $carta) {

        //         $carta_motivao = new CartaMotivacao();

        //         $carta_motivao->id_user = $novo_id_usuario;
                
        //         $array_edital = explode('-', $carta->edital);

        //         $edital = (string)$array_edital[1].'-'.$array_edital[0];

        //         foreach ($inscricoes_configuradas as $inscricao) {
                    
        //             if ($inscricao->edital === $edital) {
                        
        //                 $carta_motivao->id_inscricao_pos = $inscricao->id_inscricao_pos;

        //             }
        //         }

        //         if (is_null($carta_motivao->id_inscricao_pos)) {
                    
        //             $carta_motivao->id_inscricao_pos = 0;
        //         }

        //         $carta_motivao->motivacao = Purifier::clean(trim($carta->motivacaoprogramapretendido));
        //         $carta_motivao->concorda_termos = true;

        //         $carta_motivao->save();
        //     }

        // }

        // // //Fim da migração das cartas de motivação dos candidatos

        // // //Migra as escolhas dos candidatos

        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // $inscricoes_configuradas = ConfiguraInscricaoPos::all();

        // foreach ($users_candidato as $candidato) {
            

        //     $escolhas_candidato_antigo = DB::connection('pos2')->table('inscricao_pos_dados_profissionais_candidato')->where('id_aluno', $candidato->coduser)->orderBy('edital', 'asc')->get()->all();

        //     $novo_usuario = new User();

        //     $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //     foreach ($escolhas_candidato_antigo as $escolha_antiga) {
                
        //         $nova_escolha = new EscolhaCandidato();

        //         $nova_escolha->id_user = $novo_id_usuario;

        //         $array_edital = explode('-', $escolha_antiga->edital);

        //         $edital = (string)$array_edital[1].'-'.$array_edital[0];

        //         foreach ($inscricoes_configuradas as $inscricao) {
                    
        //             if ($inscricao->edital === $edital) {
                        
        //                 $nova_escolha->id_inscricao_pos = $inscricao->id_inscricao_pos;

        //             }
        //         }

        //         if (is_null($nova_escolha->id_inscricao_pos)) {
                    
        //             $nova_escolha->id_inscricao_pos = 0;
        //         }

        //         if (!is_null($escolha_antiga->areadoutorado)) {
                    
        //             $nova_escolha->programa_pretendido = 2;

        //         }

        //         if (strtolower(trim($escolha_antiga->cursopos)) === '0') {
        //             $nova_escolha->programa_pretendido = 3;
        //         }

        //         if (strtolower(trim($escolha_antiga->cursopos)) === 'doutorado') {
        //             $nova_escolha->programa_pretendido = 2;
        //         }

        //         if (strtolower(trim($escolha_antiga->cursopos)) === 'mestrado') {
        //             $nova_escolha->programa_pretendido = 1;
        //         }

        //         if (strtolower(trim($escolha_antiga->areadoutorado)) === 'teoriadosnumeros') {
        //                 $nova_escolha->area_pos = 9;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'teoriadacomputacao') {
        //                 $nova_escolha->area_pos = 8;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'sistemasdinamicos') {
        //                 $nova_escolha->area_pos = 7;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'probabilidade') {
        //                 $nova_escolha->area_pos = 6;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'algebra') {
        //                 $nova_escolha->area_pos = 1;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'analisenumerica') {
        //                 $nova_escolha->area_pos = 3;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'matematicaaplicada') {
        //                 $nova_escolha->area_pos = 5;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'analise') {
        //                 $nova_escolha->area_pos = 2;
        //             }

        //             if (strtolower(trim($escolha_antiga->areadoutorado)) === 'geometriadiferencial') {
        //                 $nova_escolha->area_pos = 4;
        //             }

        //         if ($escolha_antiga->interessebolsa === 'Sim') {
        //             $nova_escolha->interesse_bolsa = true;
        //         }else{
        //             $nova_escolha->interesse_bolsa = false;
        //         }

        //         $nova_escolha->vinculo_empregaticio = false;
        //         $nova_escolha->save();
                
        //     }

        // }

        // // //Fim da migração das escolhas dos candidatos

        // //Migra os contatos dos recomendantes

        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // $inscricoes_configuradas = ConfiguraInscricaoPos::all();

        // foreach ($users_candidato as $candidato) {
            
        //     $contatos_recomendantes_antigo = DB::connection('pos2')->table('inscricao_pos_contatos_recomendante')->where('id_aluno', $candidato->coduser)->orderBy('edital', 'asc')->get()->all();

        //     $novo_usuario = new User();

        //     $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //     foreach ($contatos_recomendantes_antigo as $antigo_recomendante) {

        //         $array_edital = explode('-', $antigo_recomendante->edital);

        //         $edital = (string)$array_edital[1].'-'.$array_edital[0];

        //         $id_inscricao_pos = null;

        //         foreach ($inscricoes_configuradas as $inscricao) {
                    
        //             if ($inscricao->edital === $edital) {
                        
        //                 $id_inscricao_pos = $inscricao->id_inscricao_pos;

        //             }
        //         }

        //         if (is_null($id_inscricao_pos)) {
        //             $id_inscricao_pos = 0;
        //         }


        //         $novo_usuario_recomendante1 = new User();

        //         if (!is_null($novo_usuario_recomendante1->retorna_user_por_email(strtolower(trim($antigo_recomendante->emailprofrecomendante1))))) {
        //             $novo_id_recomendante1 = $novo_usuario_recomendante1->retorna_user_por_email(strtolower(trim($antigo_recomendante->emailprofrecomendante1)))->id_user;

        //             $contatos_novos = new ContatoRecomendante();

        //             $contatos_novos->id_user = $novo_id_usuario;

        //             $contatos_novos->id_recomendante = $novo_id_recomendante1;

        //             $contatos_novos->id_inscricao_pos = $id_inscricao_pos;

        //             $contatos_novos->email_enviado = true;

        //             $contatos_novos->save();
        //         }

        //         $novo_usuario_recomendante2 = new User();

        //         if (!is_null($novo_usuario_recomendante2->retorna_user_por_email(strtolower(trim($antigo_recomendante->emailprofrecomendante2))))) {
        //             $novo_id_recomendante2 = $novo_usuario_recomendante2->retorna_user_por_email(strtolower(trim($antigo_recomendante->emailprofrecomendante2)))->id_user;

        //             $contatos_novos2 = new ContatoRecomendante();

        //             $contatos_novos2->id_user = $novo_id_usuario;

        //             $contatos_novos2->id_recomendante = $novo_id_recomendante2;

        //             $contatos_novos2->id_inscricao_pos = $id_inscricao_pos;

        //             $contatos_novos2->email_enviado = true;

        //             $contatos_novos2->save();
        //         }

        //         $novo_usuario_recomendante3 = new User();

        //         if (!is_null($novo_usuario_recomendante3->retorna_user_por_email(strtolower(trim($antigo_recomendante->emailprofrecomendante3))))) {
        //             $novo_id_recomendante3 = $novo_usuario_recomendante3->retorna_user_por_email(strtolower(trim($antigo_recomendante->emailprofrecomendante3)))->id_user;

        //             $contatos_novos3 = new ContatoRecomendante();

        //             $contatos_novos3->id_user = $novo_id_usuario;

        //             $contatos_novos3->id_recomendante = $novo_id_recomendante3;

        //             $contatos_novos3->id_inscricao_pos = $id_inscricao_pos;

        //             $contatos_novos3->email_enviado = true;

        //             $contatos_novos3->save();
        //         }
        //     }
        // }
        // //Fim da migração dos contatos dos recomendantes
        
        // // //Início da migração das cartas de recomendação
        
        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // $inscricoes_configuradas = ConfiguraInscricaoPos::all();

        // foreach ($users_candidato as $candidato) {

        //     $cartas_recomendacoes_antigas = DB::connection('pos2')->table('inscricao_pos_recomendacoes')->where('id_aluno', $candidato->coduser)->orderBy('edital', 'asc')->get()->all();
            
        //     $novo_usuario = new User();

        //     $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //     foreach ($cartas_recomendacoes_antigas as $carta_recomendacao) {
                
                
        //         $array_edital = explode('-', $carta_recomendacao->edital);

        //         $edital = (string)$array_edital[1].'-'.$array_edital[0];

        //         $id_inscricao_pos = null;

        //         foreach ($inscricoes_configuradas as $inscricao) {
                    
        //             if ($inscricao->edital === $edital) {
                        
        //                 $id_inscricao_pos = $inscricao->id_inscricao_pos;

        //             }
        //         }

        //         if (is_null($id_inscricao_pos)) {
        //             $id_inscricao_pos = 0;
        //         }
                    
        //         $novo_usuario_candidato = new User();

        //         $id_novo_usuario_candidato = $novo_usuario_candidato->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

        //         $email_recomendante = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'recomendante')->where('coduser', $carta_recomendacao->id_prof)->get()->first();

        //         $novo_usuario_recomendante = new User();

        //         $id_novo_usuario_recomendante = $novo_usuario_recomendante->retorna_user_por_email(strtolower(trim($email_recomendante->login)));

        //         $nova_carta = new CartaRecomendacao();

        //         $nova_carta->id_prof = $id_novo_usuario_recomendante->id_user;
                
        //         $nova_carta->id_aluno = $novo_id_usuario;

        //         $nova_carta->programa_pretendido = 0;

        //         if (is_null($carta_recomendacao->nivel)) {
        //             $nova_carta->programa_pretendido = 0;
        //         }

        //         if (strtolower(trim($carta_recomendacao->nivel)) === 'doutorado') {
        //             $nova_carta->programa_pretendido = 2;
        //         }

        //         if (strtolower(trim($carta_recomendacao->nivel)) === 'mestrado') {
        //             $nova_carta->programa_pretendido = 1;
        //         }

        //         if (strtolower(trim($carta_recomendacao->nivel)) === 'verão') {
        //             $nova_carta->programa_pretendido = 3;
        //         }
                

        //         $nova_carta->id_inscricao_pos = $id_inscricao_pos;

        //         $nova_carta->tempo_conhece_candidato = $carta_recomendacao->tempoconhececandidato;

        //         $nova_carta->circunstancia_1 = $carta_recomendacao->circunstancia1;

        //         $nova_carta->circunstancia_2 = $carta_recomendacao->circunstancia2;

        //         $nova_carta->circunstancia_3 = $carta_recomendacao->circunstancia3;

        //         $nova_carta->circunstancia_4 = $carta_recomendacao->circunstancia4;

        //         $nova_carta->circunstancia_outra = $carta_recomendacao->circunstanciaoutra;

        //         $nova_carta->desempenho_academico = (int) $carta_recomendacao->desempenhoacademico;

        //         if ($carta_recomendacao->desempenhoacademico === 'naoinfo') {
        //             $nova_carta->desempenho_academico = 5;
        //         }
                
        //         $nova_carta->capacidade_aprender = (int) $carta_recomendacao->capacidadeaprender;

        //         if ($carta_recomendacao->capacidadeaprender === 'naoinfo') {
        //             $nova_carta->capacidade_aprender = 5;
        //         }

        //         $nova_carta->capacidade_trabalhar = (int) $carta_recomendacao->capacidadetrabalhar;

        //         if ($carta_recomendacao->capacidadetrabalhar === 'naoinfo') {
        //             $nova_carta->capacidade_trabalhar = 5;
        //         }

        //         $nova_carta->criatividade = (int) $carta_recomendacao->criatividade;

        //         if ($carta_recomendacao->criatividade === 'naoinfo') {
        //             $nova_carta->criatividade = 5;
        //         }

        //         $nova_carta->curiosidade = (int) $carta_recomendacao->curiosidade;

        //         if ($carta_recomendacao->curiosidade === 'naoinfo') {
        //             $nova_carta->curiosidade = 5;
        //         }

        //         $nova_carta->esforco = (int) $carta_recomendacao->esforco;

        //         if ($carta_recomendacao->esforco === 'naoinfo') {
        //             $nova_carta->esforco = 5;
        //         }

        //         $nova_carta->expressao_escrita = (int) $carta_recomendacao->expressaoescrita;

        //         if ($carta_recomendacao->expressaoescrita === 'naoinfo') {
        //             $nova_carta->expressao_escrita = 5;
        //         }

        //         $nova_carta->expressao_oral = (int) $carta_recomendacao->expressaooral;

        //         if ($carta_recomendacao->expressaooral === 'naoinfo') {
        //             $nova_carta->expressao_oral = 5;
        //         }

        //         $nova_carta->relacionamento = (int) $carta_recomendacao->relacionamento;

        //         if ($carta_recomendacao->relacionamento === 'naoinfo') {
        //             $nova_carta->relacionamento = 5;
        //         }

        //         $nova_carta->antecedentes_academicos = $carta_recomendacao->antecedentesacademicos;

        //         $nova_carta->possivel_aproveitamento = $carta_recomendacao->possivelaproveitamento;

        //         $nova_carta->informacoes_relevantes = $carta_recomendacao->informacoesrelevantes;

        //         $nova_carta->como_aluno = (int) $carta_recomendacao->comoaluno;

        //         if ($carta_recomendacao->comoaluno === 'naoinfo') {
        //             $nova_carta->como_aluno = 5;
        //         }

        //         if (is_null($carta_recomendacao->comoaluno)) {
        //             $nova_carta->como_aluno = 5;
        //         }

        //         $nova_carta->como_orientando = (int) $carta_recomendacao->comoorientando;

        //         if ($carta_recomendacao->comoorientando === 'naoinfo') {
        //             $nova_carta->como_orientando = 5;
        //         }

        //         if (is_null($carta_recomendacao->comoorientando)) {
        //             $nova_carta->como_orientando = 5;
        //         }

        //         $nova_carta->completada = true;

        //         $nova_carta->save();
        //     }
        // }

        // // //Fim da migração das cartas de recomendação


        // // //Migra finalização das inscrições
        
        // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

        // $inscricoes_configuradas = ConfiguraInscricaoPos::all();

        // foreach ($users_candidato as $candidato) {

        //     $finalizada_antigas = DB::connection('pos2')->table('inscricao_pos_finaliza')->where('coduser', $candidato->coduser)->orderBy('edital', 'asc')->get()->all();
            
        //     $novo_usuario = new User();

        //     $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

            

        //     foreach ($finalizada_antigas as $antigas) {

        //         $array_edital = explode('-', $antigas->edital);

        //         $edital = (string)$array_edital[1].'-'.$array_edital[0];

        //         $id_inscricao_pos = null;

        //         foreach ($inscricoes_configuradas as $inscricao) {
                
        //             if ($inscricao->edital === $edital) {
                    
        //                 $id_inscricao_pos = $inscricao->id_inscricao_pos;
        //             }
        //         }

        //         if (is_null($id_inscricao_pos)) {
        //             $id_inscricao_pos = 0;
        //         }
                
        //         $nova_finalizada = new FinalizaInscricao();

        //         $nova_finalizada->id_user = $novo_id_usuario;

        //         $nova_finalizada->id_inscricao_pos = $id_inscricao_pos;

        //         $nova_finalizada->finalizada = true;

        //         $nova_finalizada->created_at = $antigas->data.' '.mt_rand(1, 24).':'.mt_rand(10, 60).':'.mt_rand(10, 60);

        //         $nova_finalizada->save();
        //     }
            

        // }
        
        // // Fim da migração da finalização das inscrições
  }
}