<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Exception;
use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

abstract class DataTableController extends BaseController
{
    protected $builder;

    abstract public function builder();

    public function __construct()
    {
        $builder = $this->builder();

        if (!$builder instanceof Builder) {
            throw new Exception("Entity builder not instance of Builder");
            
        }

        $this->builder = $builder;
    }

    public function index(Request $request)
    {   
        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'updatable' => $this->getUpdatableColumns(),
                'records' => $this->getRecords($request),
            ]
        ]);
    }


    public function update(Request $request)
    {

    }
    public function getDisplayableColumns()
    {
        return array_diff($this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden());
    }

    public function getCustomColumnNanes()
    {
        return [];
    }

    public function getUpdatableColumns()
    {
        return $this->getDisplayableColumns();
    }

    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }


    protected function getRecords(Request $request)
    {
        return $this->builder()->limit($request->limit)->orderBy('id_user')->get($this->getDisplayableColumns());
    }
}
