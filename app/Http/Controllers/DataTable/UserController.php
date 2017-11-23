<?php

namespace Posmat\Http\Controllers\DataTable;

use Posmat\Models\User;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;

class UserController extends DataTableController
{
    public function builder()
    {
    	return User::query();
    }

    public function getDisplayableColumns()
    {

    	return [
    		'id_user', 'email', 'locale', 'user_type', 'ativo', 'created_at'
    	];
    }

    public function getUpdatableColumns()
    {

        return [
            'email', 'locale', 'user_type', 'ativo', 'created_at'
        ];
    }

    public function update($id_user, Request $request)
    {

        $this->validate($request,[
            'email'  => 'required|unique:users|email|max:255',
            'locale' => 'required',
            'user_type' => 'required',
            'ativo' => 'required',
        ]);

        $atualiza = $this->builder->find($id_user);

        if ($request->ativo && !is_null($atualiza->validation_code)) {
            $atualiza->update(['validation_code' => null]);
        }

        $atualiza->update($request->only($this->getUpdatableColumns()));

    }

}
