<?php

namespace Posmat\Http\Controllers\DataTable;

use Exception;

use View;

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

        // $view = View::make('templates.partials.admin.user_datatable')->render();

    	return response()->json([
    		'data' => [
    			'displayable' => array_values($this->getDisplayableColumns()),
    			'records' => $this->getRecords()

    		]
    	]);
    }

    public function getDisplayableColumns()
    {

    	return array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());

    }

    protected function getDatabaseColumnNames()
    {

    	return Schema::getColumnListing($this->builder->getModel()->getTable());

    }

    protected function getRecords()
    {

    	return $this->builder->get($this->getDisplayableColumns());
    }
}
