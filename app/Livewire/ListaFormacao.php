<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;

use App\Models\Formacao;

use App\Models\ConfiguraInscricaoPos;

use View;

class ListaFormacao extends Component
{
    use WithPagination;

    public $perPage = 20;

    public $search = '';

    public $sortBy = 'created_at';

    public $sortDir = 'DESC';

    public $editingFormacaoId;

    public $editingFormacaoBR;

    public $editingFormacaoEN;

    public $editingFormacaoES;

    public $editingNivel;

    public function edit($formacaoid)
    {
        $this->editingFormacaoId = $formacaoid;

        $this->editingFormacaoBR= Formacao::find($formacaoid)->tipo_ptbr;

        $this->editingFormacaoEN = Formacao::find($formacaoid)->tipo_en;

        $this->editingFormacaoES = Formacao::find($formacaoid)->tipo_es;

        $this->editingNivel = Formacao::find($formacaoid)->nivel;

    }

    public function cancelEditing()
    {
        $this->reset('editingFormacaoId', 'editingFormacaoBR', 'editingFormacaoEN', 'editingFormacaoES', 'editingNivel');
    }

    public function update()
    {
        $validatedData = $this->validate([
            'editingFormacaoBR' => 'required|max:255',
            'editingFormacaoEN' => 'required|max:255',
            'editingFormacaoES' => 'required|max:255',
            'editingNivel' => 'required|max:255',
        ]);

        Formacao::find($this->editingFormacaoId)->update(
            [
                'tipo_ptbr' => trim($this->editingFormacaoBR),
                'tipo_en' => trim($this->editingFormacaoEN),
                'tipo_es' => trim($this->editingFormacaoES),
                'nivel' => trim($this->editingNivel),
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

        return view('livewire.lista-formacao',
            [
                'formacao' => Formacao::search($this->search)->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage)
            ])->extends('layouts.app')
            ->section('lista_formacao');
    }
}
