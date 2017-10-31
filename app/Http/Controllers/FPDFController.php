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

	public function pdfRelatorio()
	{

    $local_documentos = storage_path('app/');
    $arquivos_editais = public_path("/editais/");
		
    Fpdf::AddPag();
    Fpdf::SetFont('Courier', 'B', 18);
    Fpdf::Cell(50, 25, 'Hello World!');
    $localarquivo = $arquivos_editais.'Teste.pdf';
    Fpdf::Output($localarquivo,'F');

    // $pdf = new FPDF();
    // $pdf->AddPage();
    // $pdf->SetFont('Arial','B',16);
    // $pdf->Cell(40,10,'Hello World!');
    // $pdf->Output();

    // $pdf = new Fpdf();
    // $pdf->Open();
    // $pdf->AddPage();
    // $pdf->SetTitle(utf8_decode('Relatório Inscrição Pós'));

    // $pdf->SetFont('Arial', '', 12);


    // //Restore font and colors
    // $pdf->SetFont('Arial', '', 10);

    // $pdf->SetTextColor(0);

    // $pdf->SetFont('Arial', 'B', 10);
    // $texto = "Cod: 1";
    // $pdf->Cell(20, 2, utf8_decode($texto),0,1,'C');

    // $localarquivo = $arquivos_editais.'Teste.pdf';
    // $Fpdf::Output($localarquivo,'F');
  }
}