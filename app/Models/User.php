<?php

namespace Monitoriamat\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Monitoriamat\Notifications\ResetPassword as ResetPasswordNotification;

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
        'login', 
        'email', 
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
        return $this->get()->where('email',"=",$email)->first();

    }

    public function retorna_papeis()
    {
        return $this->groupBy('user_type')->orderBy('user_type')->pluck('user_type');
    }
}
