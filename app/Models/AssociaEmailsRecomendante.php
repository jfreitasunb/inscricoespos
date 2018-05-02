<?php

namespace Posmat\Models;

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
        return $this->all()->groupBy('email_preferido');
    }
}