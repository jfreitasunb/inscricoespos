<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use Fpdf;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Paises;
use Posmat\Models\Estado;
use Posmat\Models\Cidade;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPos;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;
use League\Csv\Writer;
use Storage;

/**
* Classe para visualização da página inicial.
*/
class FPDFController extends Fpdf
{

    public function __construct(array &$dados_candidato_para_relatorio)
    {
        $this->dados = $dados_candidato_para_relatorio;
    }

    public function pdfRelatorio()
    {
        Fpdf::AddPage();
        Fpdf::SetTitle(utf8_decode('Relatório Inscrição Pós'));

        Fpdf::SetFont('Arial', '', 12);


        //Restore font and colors
        Fpdf::SetFont('Arial', '', 10);

        Fpdf::SetTextColor(0);

        Fpdf::SetFont('Arial', 'I', 10);
        $texto = "Cod: 12dfsdfdf";
        Fpdf::Cell(20, 2, utf8_decode($texto),0,1,'C');
    }


    public function fechaPDF()
    {
        $local_relatorios = public_path("/relatorios/edital_".$this->dados['edital']."/");

        File::isDirectory($local_relatorios) or File::makeDirectory($local_relatorios,077,true,true);
        

        $arquivo_relatorio = $local_relatorios.'Relatorio_'.$this->dados['id_aluno'].'.pdf';

        Fpdf::Output($arquivo_relatorio,'F');
    }
}