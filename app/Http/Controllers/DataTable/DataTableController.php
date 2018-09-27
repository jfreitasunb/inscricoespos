<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

abstract class DataTableController extends BaseController
{
    abstract public function builder();
}
