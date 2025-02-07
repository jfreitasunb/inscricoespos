<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;

use App\Models\AreaPosMat;
use App\Models\ConfiguraInscricaoPos;
use View;

class ListaAreaPos extends Component
{
    use WithPagination;

    public $perPage = 20;

    public $search = '';

    public $sortBy = 'created_at';

    public $sortDir = 'DESC';

    public $editingAreaPosId;

    public $editingAreaPosNomeBR;

    public $editingAreaPosNomeEN;

    public $editingAreaPosNomeES;

    public function edit($areaposid)
    {
        $this->editingAreaPosId = $areaposid;

        $this->editingAreaPosNomeBR = AreaPosMat::find($areaposid)->nome_ptbr;

        $this->editingAreaPosNomeEN = AreaPosMat::find($areaposid)->nome_en;

        $this->editingAreaPosNomeES = AreaPosMat::find($areaposid)->nome_es;

    }

    public function cancelEditing()
    {
        $this->reset('editingAreaPosId', 'editingAreaPosNomeBR', 'editingAreaPosNomeEN', 'editingAreaPosNomeES');
    }

    public function update()
    {
        $validatedData = $this->validate([
            'editingAreaPosNomeBR' => 'required|max:255',
            'editingAreaPosNomeEN' => 'required|max:255',
            'editingAreaPosNomeES' => 'required|max:255',
        ]);

        AreaPosMat::find($this->editingAreaPosId)->update(
            [
                'nome_ptbr' => trim($this->editingAreaPosNomeBR),
                'nome_en' => trim($this->editingAreaPosNomeEN),
                'nome_es' => trim($this->editingAreaPosNomeES),
            ]
        );

        $this->cancelEditing();
    }

    public function updatedSearc()
    {
        $this->resetPage();
    }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy == $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : 'ASC';
            return;
        }

        $this->sortBy = $sortByField;

        $this->sortDir = 'DESC';
    }

    public function render()
    {
        $inscricao_pos = new ConfiguraInscricaoPos();

        $periodo_inscricao = $inscricao_pos->retorna_periodo_inscricao();

        $texto_inscricao_pos = $inscricao_pos->define_texto_inscricao();

        View::share('periodo_inscricao', $periodo_inscricao);

        View::share('texto_inscricao_pos', $texto_inscricao_pos);

        return view('livewire.lista-area-pos',
            [
                'areapos' => AreaPosMat::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage)
            ])->extends('layouts.app')
            ->section('lista_area_pos');
    }
}
