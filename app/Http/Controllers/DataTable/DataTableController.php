<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\BaseController;

abstract class DataTableController extends BaseController
{
    abstract public function builder();

    public function index()
    {
        # code...
    }
}
