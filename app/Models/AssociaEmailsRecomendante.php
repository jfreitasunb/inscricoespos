<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AssociaEmailsRecomendante extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id';

    protected $table = 'associa_emails_recomendante';

    protected $fillable = [
        'email_fornecido',
        'email_preferido',
    ];

    public function retorna_associacao($email_fornecido)
    {
        return $this->select('email_preferido')
            ->where('email_fornecido', $email_fornecido)
            ->value('email_preferido');
    }

    public function retorna_associacoes()
    {
        $associacoes_existentes = DB::select("SELECT email_preferido, ARRAY_AGG(email_fornecido) AS email_fornecido FROM associa_emails_recomendante GROUP BY
     email_preferido");

        $array_associacoes = [];
        foreach ($associacoes_existentes as $key => $associacao) {
            $temp =  explode(',', str_replace('}', '', str_replace('{', '', $associacao->email_fornecido)));

            for ($i=0; $i < sizeof($temp); $i++) { 
                $array_associacoes[$associacao->email_preferido][$i] = $temp[$i];
            }
        }

        return $array_associacoes;
    }
}