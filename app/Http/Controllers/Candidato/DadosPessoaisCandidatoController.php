<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

class DadosPessoaisCandidatoController extends BaseController
{
    public $locale_default = 'pt_BR';

    public function getDadosPessoais()
    {

        // $getcountries = new APIController();

        // $countries = $getcountries->index();

        // $user = $this->SetUser();
        
        // $id_user = $user->id_user;

        // $editar_dados = false;
        
        // $candidato = new DadoPessoalCandidato();
        
        // $dados_pessoais = $candidato->retorna_dados_pessoais($id_user);

        // if (is_null($dados_pessoais)) {
            
        //     $dados = [
        //         'nome' => $this->titleCase($user->nome),
        //         'data_nascimento' => '',
        //         'numerorg' => '',
        //         'emissorrg' => '',
        //         'cpf' => '',
        //         'data_nascimento' => '',
        //         'endereco' => '',
        //         'pais' => '',
        //         'estado' => '',
        //         'cidade' => '',
        //         'cep' => '',
        //         'celular' => '',
        //     ];
        // }else{
            
        //     if (!is_null($dados_pessoais->data_nascimento)) {
            
        //         $nascimento = Carbon::createFromFormat('Y-m-d',$dados_pessoais->data_nascimento);

        //         $data_nascimento = $nascimento->format('d/m/Y');
        //     }else{
            
        //         $data_nascimento = '';
        //     }
            

        //     $nome_pais = new Paises;

        //     $nome_estado = new Estado;

        //     $nome_cidade = new Cidade;

        //     if (!is_null($dados_pessoais->pais)) {
            
        //         $pais = $nome_pais->retorna_nome_pais_por_id($dados_pessoais->pais);
        //     }else{

        //         $pais = '';
        //     }

        //     if (!is_null($dados_pessoais->estado)) {
            
        //         $estado = $nome_estado->retorna_nome_estados_por_id($dados_pessoais->pais, $dados_pessoais->estado);
        //     }else{

        //         $estado = '';
        //     }

        //     if (!is_null($dados_pessoais->cidade)) {
                
        //         $cidade = $nome_cidade->retorna_nome_cidade_por_id($dados_pessoais->cidade, $dados_pessoais->estado);
        //     }else{

        //         $cidade = '';
        //     }

        //     $dados = [
        //         'nome' => $this->titleCase($dados_pessoais->nome),
        //         'data_nascimento' => $dados_pessoais->data_nascimento,
        //         'numerorg' => $dados_pessoais->numerorg,
        //         'emissorrg' => $dados_pessoais->emissorrg,
        //         'cpf' => $dados_pessoais->cpf,
        //         'data_nascimento' => $data_nascimento,
        //         'endereco' => $dados_pessoais->endereco,
        //         'pais' => $pais,
        //         'estado' => $estado,
        //         'cidade' => $cidade,
        //         'cep' => $dados_pessoais->cep,
        //         'celular' => $dados_pessoais->celular,
        //     ];
        // }

        // return view('layouts.candidato.dados_pessoais')->with(compact('countries','dados','editar_dados'));
        return view('layouts.candidato.dados_pessoais');
    }

}
