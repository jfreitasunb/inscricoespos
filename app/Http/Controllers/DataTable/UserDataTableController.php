<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;

class UserDataTableController extends DataTableController
{
    public function builder()
    {
        return User::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_user', 'nome', 'email', 'locale', 'user_type', 'ativo'
        ];
    }

    public function getUpdatableColumns()
    {
        return [
            'nome', 'email', 'locale', 'user_type', 'ativo'
        ];
    }
}
