<?php

namespace App\Http\Controllers\Coordenador;

use App\Http\Controllers\Controller;
use App\Models\ProgramaPos;
use App\Models\ConfiguraInscricaoPos;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App;

use Auth;

use Session;

use File;

class ConfiguraInscricaoPosController extends CoordenadorController
{
    public function getConfiguraInscricao()
    {
        $programas_pos_mat = ProgramaPos::get()->all();

        return view('layouts.coordenador.configura_inscricao')->with(compact('programas_pos_mat'));
    }

    public function postConfiguraInscricao(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao|after:today',
            'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao|after:today',
            'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao|after:fim_inscricao|after:today',
            'data_homologacao' => 'required|date_format:"Y-m-d"|after:fim_inscricao|after:today',
            'data_divulgacao_resultado' => 'required|date_format:"Y-m-d"|after:data_homologacao|after:today',
            'necessita_recomendante' => 'required',
            'edital_ano' => 'required',
            'edital_numero' => 'required',
            'escolhas_coordenador' => 'required',
        ]);

        $configura_nova_inscricao_pos = new ConfiguraInscricaoPos();

        $user = Auth::user();

        $local_documentos = storage_path('app/');

        $arquivos_editais = storage_path("app/public/editais/");

        File::isDirectory($arquivos_editais) or File::makeDirectory($arquivos_editais,0775,true);
        
        // dd($request->inicio_inscricao);
        $inicio = Carbon::createFromFormat('Y-m-d', $request->inicio_inscricao);
        $fim = Carbon::createFromFormat('Y-m-d', $request->fim_inscricao);
        $prazo = Carbon::createFromFormat('Y-m-d', $request->prazo_carta);
        $homologacao = Carbon::createFromFormat('Y-m-d', $request->data_homologacao);
        $divulgacao_resultado = Carbon::createFromFormat('Y-m-d', $request->data_divulgacao_resultado);

        $necessita_recomendante = $request->necessita_recomendante;

        $data_inicio = $inicio->format('Y-m-d');
        dd($data_inicio);
        $data_fim = $fim->format('Y-m-d');
        $semestre_inicio = $request->semestre_inicio;
        $prazo_carta = $prazo->format('Y-m-d');
        $data_homologacao = $homologacao->format('Y-m-d');
        $data_divulgacao_resultado = $divulgacao_resultado->format('Y-m-d');

        dd("Aqui");
    }
}
