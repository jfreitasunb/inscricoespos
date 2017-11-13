<?php

namespace Posmat\Http\Controllers\DataTable;

use Exception;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Schema;

abstract class DataTableController extends Controller
{
	protected $builder;

	public function __construct()
	{
		$builder = $this->builder();

		if (!$builder instanceof Builder) {
			
			throw new Exception("Entity builder not instance of Builder");

		}

		$this->builder = $builder;
	}

    abstract public function builder();

    public function index()
    {

    	return response()->json([
    		'data' => [
    			'records' => $this->getRecords(),
    			'displayable' => $this->getDisplayableColumns()

    		]
    	]);
    }

    public function getDisplayableColumns()
    {

    	return Schema::getColumnListing($this->builder->getModel()->getTable());

    }

    protected function getRecords()
    {

    	return $this->builder->get();
    }
}
