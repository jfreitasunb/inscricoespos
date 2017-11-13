<?php

namespace Posmat\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;

abstract class DataTableController extends Controller
{
    abstract public function builder();
}
