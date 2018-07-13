<?php

namespace InscricoesPos\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use Fpdf;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\DadoPessoal;
use InscricoesPos\Models\Paises;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\Cidade;
use InscricoesPos\Models\DadoAcademico;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\AreaInscricoesPos;
use InscricoesPos\Models\ProgramaPos;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
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
        Fpdf::Close($arquivo_relatorio);
    }
}