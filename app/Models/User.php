<?php

namespace Posmat\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Posmat\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'email',
        'locale',
        'password',
        'validation_code',
        'ativo',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function verified()
    {
        $this->ativo = 1;
        $this->validation_code = null;
        $this->save();
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function retorna_user_por_email($email)
    {
        return $this->get()->where('email',$email)->first();

    }

    public function retorna_papeis()
    {
        return $this->groupBy('user_type')->orderBy('user_type')->pluck('user_type');
    }

    public function isAdmin()
    {
        if (auth()->user()->user_type === 'admin') {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function isCoordenador()
    {

        if (auth()->user()->user_type === 'coordenador') {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function isAluno()
    {
        if (auth()->user()->user_type === 'aluno') {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function isRecomendante()
    {
        if (auth()->user()->user_type === 'recomendante') {
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
