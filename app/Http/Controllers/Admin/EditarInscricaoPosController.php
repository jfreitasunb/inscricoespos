<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ConfiguraInscricaoPos;

use App;

use Auth;

use Session;

class EditarInscricaoPosController extends AdminController
{

    public function getEditarInscricao()
    {
        $edital = new ConfiguraInscricaoPos();

        $edital_vigente = $edital->retorna_edital_vigente();

        return view('layouts.admin.editar_inscricao')->with(compact('edital_vigente'));
    }

    public function postEditarInscricao(Request $request)
    {

        $this->validate($request, [
            'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao',
            'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
            'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
            'data_homologacao' => 'required|date_format:"Y-m-d"|after:fim_inscricao',
            'data_divulgacao_resultado' => 'required|date_format:"Y-m-d"|after:data_homologacao',
            'edital' => 'required',
            'programa' => 'required',
            'necessita_recomendante' => 'required',
        ]);

        if ($request->necessita_semestre_inicio){
            $this->validate($request, [
                'semestre_inicio' => 'required',
            ]);
        }

        $edital_vigente = ConfiguraInscricaoPos::find((int)$request->id_inscricao_pos);

        $novos_dados_edital['inicio_inscricao'] = $request->inicio_inscricao;
        $novos_dados_edital['fim_inscricao'] = $request->fim_inscricao;
        $novos_dados_edital['prazo_carta'] = $request->prazo_carta;
        $novos_dados_edital['programa'] = $request->programa;
        $novos_dados_edital['edital'] = $request->edital;

        if ($request->necessita_semestre_inicio) {

            $temp = strtolower($request->necessita_recomendante);

            switch ($temp) {
                case 'sim':
                    $necessita_semestre_inicio = true;
                    break;
                case 'Sim':
                    $necessita_semestre_inicio = true;
                    break;

                case 's':
                    $necessita_semestre_inicio = true;
                    break;
                case '1':
                    $necessita_semestre_inicio = true;
                    break;

                default:
                    $necessita_semestre_inicio = false;
                    break;
            }

            $novos_dados_edital['necessita_semestre_inicio'] = $necessita_semestre_inicio;
            $novos_dados_edital['semestre_inicio'] = $request->semestre_inicio;
        }

        $novos_dados_edital['data_homologacao'] = $request->data_homologacao;
        $novos_dados_edital['data_divulgacao_resultado'] = $request->data_divulgacao_resultado;

        $temp = strtolower($request->necessita_recomendante);

        switch ($temp) {
            case 'nao':
                $necessita_recomendante = false;
                break;
            case 'não':
                $necessita_recomendante = false;
                break;

            case 'n':
                $necessita_recomendante = false;
                break;
            case '0':
                $necessita_recomendante = false;
                break;

            default:
                $necessita_recomendante = true;
                break;
        }

        $novos_dados_edital['necessita_recomendante'] = $necessita_recomendante;

        $edital_vigente->update($novos_dados_edital);

        return redirect()->route('editar.inscricao')->with('success', 'Inscrição configurada com sucesso.');
    }
}
