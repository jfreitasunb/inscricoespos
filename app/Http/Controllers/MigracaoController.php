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

/**
* Classe para visualização da página inicial.
*/
class MigracaoController extends BaseController
{
  public function getMigracao()
  {
    //Migra usuários para novo sistema

    // $users = DB::connection('pos2')->table('inscricao_pos_login')->orderBy('coduser', 'asc')->get();

    // foreach ($users as $user) {
    //   if ($user->coduser !=197) {
    //     $novo_usuario = new User();
    //     if ($user->coduser == 348 or $user->coduser == 567 or $user->coduser == 565 or $user->coduser == 566 or $user->coduser == 563 or $user->coduser == 557 or $user->coduser == 685 or $user->coduser == 632 or $user->coduser == 530 or $user->coduser == 989 or $user->coduser == 1339 or $user->coduser == 415 or $user->coduser == 470 or $user->coduser == 472 or $user->coduser == 2124 or $user->coduser == 2125 or $user->coduser == 667 or $user->coduser == 225 or $user->coduser == 350 or $user->coduser == 593 or $user->coduser == 1881) {
    //       $novo_usuario->email = Purifier::clean(strtolower(trim($user->login)).'.duplicado');
    //     }else{
    //       $novo_usuario->email = Purifier::clean(strtolower(trim($user->login)));
    //     }
    //     $novo_usuario->password = bcrypt(1);
    //     $novo_usuario->validation_code = null;
    //     $novo_usuario->user_type = $user->status;
    //     $novo_usuario->ativo = true;
    //     $novo_usuario->save(); 
    //   }
    // }
    
    //Fim da migração dos usuário para o novo sistema

    //Migra dados pessoais dos candidatos para o novo sistema

    $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->orderBy('coduser','asc')->get();

    $array_brasil = [
        0 => 'barasil',
        1 => 'barsil',
        2 => 'br',
        3 => 'brasil',
        4 => 'brasil',
        5 => 'brasil',
        6 => 'brasil',
        7 => 'brasil',
        8 => 'brasil',
        9 => 'brasíl',
        10 => 'brasíl',
        11 => 'brasileiro',
        12 => 'brasio',
        13 => 'braszil',
        14 => 'brazil',
        14 => 'brazil',
    ];

    $array_colombia = [
        0 => 'colombia',
        1 => 'colômbia',
    ];

    $array_peru = [
        0 => 'peru',
        1 => 'perú',
    ];


    foreach ($users_candidato as $candidato) {

      if ($candidato->coduser == 348 or $candidato->coduser == 567 or $candidato->coduser == 565 or $candidato->coduser == 566 or $candidato->coduser == 563 or $candidato->coduser == 557 or $candidato->coduser == 685 or $candidato->coduser == 632 or $candidato->coduser == 530 or $candidato->coduser == 989 or $candidato->coduser == 1339 or $candidato->coduser == 415 or $candidato->coduser == 470 or $candidato->coduser == 472 or $candidato->coduser == 2124 or $candidato->coduser == 2125 or $candidato->coduser == 667 or $candidato->coduser == 225 or $candidato->coduser == 350 or $candidato->coduser == 593 or $candidato->coduser == 1881) {
           $candidato->email = Purifier::clean(strtolower(trim($candidato->login)).'.duplicado');
         }else{
           $candidato->email = Purifier::clean(strtolower(trim($candidato->login)));
         }

        $dados_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_candidato')->where('id_aluno', $candidato->coduser)->first();

         
        if (!is_null($dados_antigos_usuario)) {
            $novo_usuario = new User();

            $novo_id_usuario = $novo_usuario->retorna_user_por_email(strtolower(trim($candidato->login)))->id_user;

            $novos_dados_pessoais = new DadoPessoal();

            $existe_dados_pessoais = $novos_dados_pessoais->retorna_dados_pessoais($novo_id_usuario);

            if (is_null($existe_dados_pessoais)) {

                $novos_dados_pessoais->id_user = $novo_id_usuario;

                $novos_dados_pessoais->nome = trim($dados_antigos_usuario->name).' '.trim($dados_antigos_usuario->firstname);

                $novos_dados_pessoais->data_nascimento = trim($dados_antigos_usuario->anonascimento).'-'.trim($dados_antigos_usuario->mesnascimento).'-'.trim($dados_antigos_usuario->dianascimento);

                $novos_dados_pessoais->numerorg = trim($dados_antigos_usuario->identity);

                $novos_dados_pessoais->endereco = trim($dados_antigos_usuario->adresse);

                $novos_dados_pessoais->cep = trim($dados_antigos_usuario->cpendereco);

                if (in_array(strtolower(trim($dados_antigos_usuario->paisnacionalidade)), $array_brasil)) {
                    
                    $novos_dados_pessoais->pais = 30;
                }

                if (in_array(strtolower(trim($dados_antigos_usuario->paisnacionalidade)), $array_colombia)) {
                    
                    $novos_dados_pessoais->pais = 47;
                }

                if (in_array(strtolower(trim($dados_antigos_usuario->paisnacionalidade)), $array_peru)) {
                    
                    $novos_dados_pessoais->pais = 172;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'argentina'))) {
                    $novos_dados_pessoais->pais = 10;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'bolivia'))) {
                    $novos_dados_pessoais->pais = 26;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'chile'))) {
                    $novos_dados_pessoais->pais = 43;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'china'))) {
                    $novos_dados_pessoais->pais = 44;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'cuba'))) {
                    $novos_dados_pessoais->pais = 55;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'ecuador'))) {
                    $novos_dados_pessoais->pais = 63;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'eua'))) {
                    $novos_dados_pessoais->pais = 231;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'frança'))) {
                    $novos_dados_pessoais->pais = 75;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'guatemala'))) {
                    $novos_dados_pessoais->pais = 90;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'haiti'))) {
                    $novos_dados_pessoais->pais = 95;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'iran'))) {
                    $novos_dados_pessoais->pais = 103;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'mocambique'))) {
                    $novos_dados_pessoais->pais = 149;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'neyshabour'))) {
                    $novos_dados_pessoais->pais = 103;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'paquistão'))) {
                    $novos_dados_pessoais->pais = 166;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'taiwan'))) {
                    $novos_dados_pessoais->pais = 214;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'turcomenistão'))) {
                    $novos_dados_pessoais->pais = 224;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'venezuela'))) {
                    $novos_dados_pessoais->pais = 237;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AC'){
                    $novos_dados_pessoais->estado = 512;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AL'){
                    $novos_dados_pessoais->estado = 513;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AM'){
                    $novos_dados_pessoais->estado = 515;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AP'){
                    $novos_dados_pessoais->estado = 514;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_BA'){
                    $novos_dados_pessoais->estado = 516;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_CE'){
                    $novos_dados_pessoais->estado = 517;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_DF'){
                    $novos_dados_pessoais->estado = 518;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_ES'){
                    $novos_dados_pessoais->estado = 519;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_GO'){
                    $novos_dados_pessoais->estado = 520;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MA'){
                    $novos_dados_pessoais->estado = 522;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MG'){
                    $novos_dados_pessoais->estado = 525;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MS'){
                    $novos_dados_pessoais->estado = 524;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MT'){
                    $novos_dados_pessoais->estado = 523;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PA'){
                    $novos_dados_pessoais->estado = 526;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PB'){
                    $novos_dados_pessoais->estado = 527;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PE'){
                    $novos_dados_pessoais->estado = 529;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PI'){
                    $novos_dados_pessoais->estado = 530;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PR'){
                    $novos_dados_pessoais->estado = 528;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RJ'){
                    $novos_dados_pessoais->estado = 533;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RN'){
                    $novos_dados_pessoais->estado = 531;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RO'){
                    $novos_dados_pessoais->estado = 534;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RR'){
                    $novos_dados_pessoais->estado = 535;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RS'){
                    $novos_dados_pessoais->estado = 532;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_SC'){
                    $novos_dados_pessoais->estado = 536;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_SE'){
                    $novos_dados_pessoais->estado = 538;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_SP'){
                    $novos_dados_pessoais->estado = 520;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_TO'){
                    $novos_dados_pessoais->estado = 539;
                }



                $novos_dados_pessoais->celular = trim($dados_antigos_usuario->ddd_cel).trim($dados_antigos_usuario->telcelular);

                $novos_dados_pessoais->save();   
            }else{

                $atualiza_dados_pessoais['nome'] = trim($dados_antigos_usuario->name).' '.trim($dados_antigos_usuario->firstname);

                $atualiza_dados_pessoais['data_nascimento'] = trim($dados_antigos_usuario->anonascimento).'-'.trim($dados_antigos_usuario->mesnascimento).'-'.trim($dados_antigos_usuario->dianascimento);

                $atualiza_dados_pessoais['numerorg'] = trim($dados_antigos_usuario->identity);

                $atualiza_dados_pessoais['endereco'] = trim($dados_antigos_usuario->adresse);

                $atualiza_dados_pessoais['cep'] = trim($dados_antigos_usuario->cpendereco);

                if (in_array(strtolower(trim($dados_antigos_usuario->paisnacionalidade)), $array_brasil)) {
                    
                    $atualiza_dados_pessoais['pais'] = 30;
                }

                if (in_array(strtolower(trim($dados_antigos_usuario->paisnacionalidade)), $array_colombia)) {
                    
                    $atualiza_dados_pessoais['pais'] = 47;
                }

                if (in_array(strtolower(trim($dados_antigos_usuario->paisnacionalidade)), $array_peru)) {
                    
                    $atualiza_dados_pessoais['pais'] = 172;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'argentina'))) {
                    $atualiza_dados_pessoais['pais'] = 10;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'bolivia'))) {
                    $atualiza_dados_pessoais['pais'] = 26;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'chile'))) {
                    $atualiza_dados_pessoais['pais'] = 43;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'china'))) {
                    $atualiza_dados_pessoais['pais'] = 44;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'cuba'))) {
                    $atualiza_dados_pessoais['pais'] = 55;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'ecuador'))) {
                    $atualiza_dados_pessoais['pais'] = 63;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'eua'))) {
                    $atualiza_dados_pessoais['pais'] = 231;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'frança'))) {
                    $atualiza_dados_pessoais['pais'] = 75;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'guatemala'))) {
                    $atualiza_dados_pessoais['pais'] = 90;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'haiti'))) {
                    $atualiza_dados_pessoais['pais'] = 95;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'iran'))) {
                    $atualiza_dados_pessoais['pais'] = 103;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'mocambique'))) {
                    $atualiza_dados_pessoais['pais'] = 149;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'neyshabour'))) {
                    $atualiza_dados_pessoais['pais'] = 103;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'paquistão'))) {
                    $atualiza_dados_pessoais['pais'] = 166;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'taiwan'))) {
                    $atualiza_dados_pessoais['pais'] = 214;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'turcomenistão'))) {
                    $atualiza_dados_pessoais['pais'] = 224;
                }

                if (strtolower(trim($dados_antigos_usuario->paisnacionalidade === 'venezuela'))) {
                    $atualiza_dados_pessoais['pais'] = 237;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AC'){
                    $atualiza_dados_pessoais['estado'] = 512;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AL'){
                    $atualiza_dados_pessoais['estado'] = 513;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AM'){
                    $atualiza_dados_pessoais['estado'] = 515;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_AP'){
                    $atualiza_dados_pessoais['estado'] = 514;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_BA'){
                    $atualiza_dados_pessoais['estado'] = 516;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_CE'){
                    $atualiza_dados_pessoais['estado'] = 517;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_DF'){
                    $atualiza_dados_pessoais['estado'] = 518;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_ES'){
                    $atualiza_dados_pessoais['estado'] = 519;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_GO'){
                    $atualiza_dados_pessoais['estado'] = 520;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MA'){
                    $atualiza_dados_pessoais['estado'] = 522;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MG'){
                    $atualiza_dados_pessoais['estado'] = 525;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MS'){
                    $atualiza_dados_pessoais['estado'] = 524;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_MT'){
                    $atualiza_dados_pessoais['estado'] = 523;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PA'){
                    $atualiza_dados_pessoais['estado'] = 526;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PB'){
                    $atualiza_dados_pessoais['estado'] = 527;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PE'){
                    $atualiza_dados_pessoais['estado'] = 529;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PI'){
                    $atualiza_dados_pessoais['estado'] = 530;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_PR'){
                    $atualiza_dados_pessoais['estado'] = 528;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RJ'){
                    $atualiza_dados_pessoais['estado'] = 533;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RN'){
                    $atualiza_dados_pessoais['estado'] = 531;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RO'){
                    $atualiza_dados_pessoais['estado'] = 534;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RR'){
                    $atualiza_dados_pessoais['estado'] = 535;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_RS'){
                    $atualiza_dados_pessoais['estado'] = 532;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_SC'){
                    $atualiza_dados_pessoais['estado'] = 536;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_SE'){
                    $atualiza_dados_pessoais['estado'] = 538;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_SP'){
                    $atualiza_dados_pessoais['estado'] = 520;
                }

                if ($dados_antigos_usuario->ufnaturalidade === 'UF_TO'){
                    $atualiza_dados_pessoais['estado'] = 539;
                }

                $atualiza_dados_pessoais['celular'] = trim($dados_antigos_usuario->ddd_cel).trim($dados_antigos_usuario->telcelular);

                $existe_dados_pessoais->update($atualiza_dados_pessoais);
            }            
        }
    }

    //Fim da Migração dos dados pessoais dos candidatos para o novo sistema
    
    //Migra os dados pessoais dos recomendantes para o novo sistema

    // $users_recomendante = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'recomendante')->orderBy('coduser','asc')->get();

    // foreach ($users_recomendante as $recomendante) {

    //   if ($recomendante->coduser == 348 or $recomendante->coduser == 567 or $recomendante->coduser == 565 or $recomendante->coduser == 566 or $recomendante->coduser == 563 or $recomendante->coduser == 557 or $recomendante->coduser == 685 or $recomendante->coduser == 632 or $recomendante->coduser == 530 or $recomendante->coduser == 989 or $recomendante->coduser == 1339 or $recomendante->coduser == 415 or $recomendante->coduser == 470 or $recomendante->coduser == 472 or $recomendante->coduser == 2124 or $recomendante->coduser == 2125 or $recomendante->coduser == 667 or $recomendante->coduser == 225 or $recomendante->coduser == 350 or $recomendante->coduser == 593 or $recomendante->coduser == 1881) {
    //        $recomendante->email = Purifier::clean(strtolower(trim($recomendante->login)).'.duplicado');
    //      }else{
    //        $recomendante->email = Purifier::clean(strtolower(trim($recomendante->login)));
    //      }

    //     $dados_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_pessoais_recomendante')->where('id_prof', $recomendante->coduser)->first();

         
    //     if (!is_null($dados_antigos_usuario)) {
    //         $novo_usuario = new User();

    //         $novo_id_usuario = $novo_usuario->retorna_user_por_email($recomendante->email)->id_user;

    //         $novos_dados_pessoais = new DadoRecomendante();

    //         $existe_dados_pessoais = $novos_dados_pessoais->retorna_dados_pessoais_recomendante($novo_id_usuario);

    //         if (is_null($existe_dados_pessoais)) {

    //             $novos_dados_pessoais->id_prof = $novo_id_usuario;

    //             $novos_dados_pessoais->nome_recomendante = trim($dados_antigos_usuario->nomerecomendante);

    //             $novos_dados_pessoais->instituicao_recomendante = trim($dados_antigos_usuario->instituicaorecomendante);

    //             $novos_dados_pessoais->titulacao_recomendante = trim($dados_antigos_usuario->titulacaorecomendante);

    //             $novos_dados_pessoais->area_recomendante = trim($dados_antigos_usuario->arearecomendante);

    //             $novos_dados_pessoais->ano_titulacao = trim($dados_antigos_usuario->anoobtencaorecomendante);

    //             $novos_dados_pessoais->inst_obtencao_titulo = trim($dados_antigos_usuario->instobtencaorecomendante);

    //             $novos_dados_pessoais->endereco_recomendante = trim($dados_antigos_usuario->enderecorecomendante);

    //             $novos_dados_pessoais->save();   
    //         }else{

    //             $atualiza_dados_pessoais['nome_recomendante'] = trim($dados_antigos_usuario->nomerecomendante);

    //             $atualiza_dados_pessoais['instituicao_recomendante'] = trim($dados_antigos_usuario->instituicaorecomendante);;

    //             $atualiza_dados_pessoais['titulacao_recomendante'] = trim($dados_antigos_usuario->titulacaorecomendante);

    //             $atualiza_dados_pessoais['area_recomendante'] = trim($dados_antigos_usuario->arearecomendante);

    //             $atualiza_dados_pessoais['ano_titulacao'] = trim($dados_antigos_usuario->anoobtencaorecomendante);

    //             $atualiza_dados_pessoais['inst_obtencao_titulo'] = trim($dados_antigos_usuario->instobtencaorecomendante);

    //             $atualiza_dados_pessoais['endereco_recomendante'] = trim($dados_antigos_usuario->enderecorecomendante);

    //             $existe_dados_pessoais->update($atualiza_dados_pessoais);
    //         }            
    //     }
    // }

    // //Fim da migração dos dados pessoais do candidato para o novo sistema

    // //Migra dados acadêmicos dos candidatos para o novo sistema.

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

    // //Fim da migração dos dados acadêmicos dos candidatos para o novo sistema.

    // //Migra documentos para o novo sistema

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

    //             $documento->nome_arquivo = 'uploads/'.$nome_crypt_historico.'.'.File::extension($documento_enviado->nome_arquivo);

    //             $documento->tipo_arquivo = 'Histórico';

    //             $documento->save();
    //         }
    //     }
        
    // }

    // //Fim da migração dos documentos para o novo sistema.

    // //Migra as cartas de motivação dos candidatos

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

    // //Fim da migração das cartas de motivação dos candidatos

    // //Migra as escolhas dos candidatos

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

    // //Fim da migração das escolhas dos candidatos

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
    
    // //Início da migração das cartas de recomendação
    
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

    //         $nova_carta->desempenho_academico = $carta_recomendacao->desempenhoacademico;

    //         if ($carta_recomendacao->desempenhoacademico === 'naoinfo') {
    //             $nova_carta->desempenho_academico = 5;
    //         }
            
    //         $nova_carta->capacidade_aprender = $carta_recomendacao->capacidadeaprender;

    //         if ($carta_recomendacao->capacidadeaprender === 'naoinfo') {
    //             $nova_carta->capacidade_aprender = 5;
    //         }

    //         $nova_carta->capacidade_trabalhar = $carta_recomendacao->capacidadetrabalhar;

    //         if ($carta_recomendacao->capacidadetrabalhar === 'naoinfo') {
    //             $nova_carta->capacidade_trabalhar = 5;
    //         }

    //         $nova_carta->criatividade = $carta_recomendacao->criatividade;

    //         if ($carta_recomendacao->criatividade === 'naoinfo') {
    //             $nova_carta->criatividade = 5;
    //         }

    //         $nova_carta->curiosidade = $carta_recomendacao->curiosidade;

    //         if ($carta_recomendacao->curiosidade === 'naoinfo') {
    //             $nova_carta->curiosidade = 5;
    //         }

    //         $nova_carta->esforco = $carta_recomendacao->esforco;

    //         if ($carta_recomendacao->esforco === 'naoinfo') {
    //             $nova_carta->esforco = 5;
    //         }

    //         $nova_carta->expressao_escrita = $carta_recomendacao->expressaoescrita;

    //         if ($carta_recomendacao->expressaoescrita === 'naoinfo') {
    //             $nova_carta->expressao_escrita = 5;
    //         }

    //         $nova_carta->expressao_oral = $carta_recomendacao->expressaooral;

    //         if ($carta_recomendacao->expressaooral === 'naoinfo') {
    //             $nova_carta->expressao_oral = 5;
    //         }

    //         $nova_carta->relacionamento = $carta_recomendacao->relacionamento;

    //         if ($carta_recomendacao->relacionamento === 'naoinfo') {
    //             $nova_carta->relacionamento = 5;
    //         }

    //         $nova_carta->antecedentes_academicos = $carta_recomendacao->antecedentesacademicos;

    //         $nova_carta->possivel_aproveitamento = $carta_recomendacao->possivelaproveitamento;

    //         $nova_carta->informacoes_relevantes = $carta_recomendacao->informacoesrelevantes;

    //         $nova_carta->como_aluno = $carta_recomendacao->comoaluno;

    //         if ($carta_recomendacao->comoaluno === 'naoinfo') {
    //             $nova_carta->como_aluno = 5;
    //         }

    //         if (is_null($carta_recomendacao->comoaluno)) {
    //             $nova_carta->como_aluno = 5;
    //         }

    //         $nova_carta->como_orientando = $carta_recomendacao->comoorientando;

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

    // //Fim da migração das cartas de recomendação


    // //Migra finalização das inscrições
    
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
    
    //Fim da migração da finalização das inscrições

  }
}