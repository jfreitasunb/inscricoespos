<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class CartaMotivacao extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'carta_motivacaos';

    protected $fillable = [
        'motivacao',
    ];
}
