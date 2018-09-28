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

    public function index()
    {   
        return response()->json([
            'data' => [
                'displayable' => $this->getDisplayableColumns(),
                'records' => $this->getRecords(),
            ]
        ]);
    }

    public function getDisplayableColumns()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

    protected function getRecords()
    {
        return $this->builder()->get();
    }
}
