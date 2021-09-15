<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;

use Illuminate\Validation\Rule;

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

    public function getCustomColumnNanes()
    {
        return [
            'id_user' => 'Identificador',
            'nome' => 'Nome',
            'email' => 'E-mail',
            'locale' => 'Idioma',
            'user_type' => 'Tipo de Usuário',
            'ativo' => 'Ativo',
        ];
    }

    public function update($id_user, Request $request)
    {
        $this->validate($request, [
            'nome' => 'required|max:255',
            'email'  => 'required|email|max:255',
            'locale' => [
                    'required', Rule::in(['en', 'es', 'pt-br'])
                        ],
            'user_type' => [
                    'required', Rule::in(['coordenador', 'candidato', 'recomendante'])
                        ],
            'ativo' => 'required',
        ]);

        $this->builder->find($id_user)->update($request->only($this->getUpdatableColumns()));
    }
}
