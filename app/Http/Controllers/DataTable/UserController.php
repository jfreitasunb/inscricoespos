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

}
