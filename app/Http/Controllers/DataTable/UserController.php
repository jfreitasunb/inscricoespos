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
}
