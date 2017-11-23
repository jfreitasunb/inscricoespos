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

    public function index(Request $request)
    {

        // $view = View::make('templates.partials.admin.user_datatable')->render();

    	return response()->json([
    		'data' => [
                'table' => $this->builder->getModel()->getTable(),

    			'displayable' => array_values($this->getDisplayableColumns()),

                'updatable' => array_values($this->getUpdatableColumns()),
                
    			'records' => $this->getRecords($request)

    		]
    	]);
    }

    public function update($id_user, Request $request)
    {

        $this->builder->find($id_user)->update($request->only($this->getUpdatableColumns()));

    }

    public function getDisplayableColumns()
    {

    	return $this->getDisplayableColumns();

    }

    public function getUpdatableColumns()
    {

        return array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());

    }

    protected function getDatabaseColumnNames()
    {

    	return Schema::getColumnListing($this->builder->getModel()->getTable());

    }

    protected function getRecords(Request $request)
    {

        $builder = $this->builder;

        if ($this->hasSearchQuery($request)) {
            
            $builder = $this->buildSearch($builder, $query);
        }


    	return $this->builder->limit($request->limit)->orderBy('id_user', 'desc')->get($this->getDisplayableColumns());
    }

    protected function hasSearchQuery(Request $request)
    {

        return count(array_filter($request->only(['column', 'operator', 'value']))) === 3;


    }

    protected function buildSearch(Builder $builder, Request $request)
    {

    }
}
