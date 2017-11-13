<?php

namespace Posmat\Http\Controllers\DataTable;

use Exception;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

abstract class DataTableController extends Controller
{
	protected $builder;

	public function __construct()
	{
		$builder = $this->builder();

		if (!$builder instanceof Builder) {
			
			throw new Exception("Entity builder not instance of Builder");

		}
	}

    abstract public function builder();

    public function index()
    {

    }
}
