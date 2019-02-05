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

    public function update($id_user, Request $request)
    {
        $this->validate($request, [
            'nome' => 'required|max:255',
            'email'  => 'required|unique:users|email|max:255',
            'locale' => 'required',
            'user_type' => 'required',
            'ativo' => 'required',
        ]);

        $this->builder->find($id_user)->update($request->only($this->getUpdatableColumns()));
    }
}
