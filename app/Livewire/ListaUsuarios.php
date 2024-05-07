<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;

use App\Models\User;
use App\Models\ConfiguraInscricaoPos;
use View;

class ListaUsuarios extends Component
{
    use WithPagination;

    public $perPage = 5;

    public function render()
    {
        $inscricao_pos = new ConfiguraInscricaoPos();

    $periodo_inscricao = $inscricao_pos->retorna_periodo_inscricao();

    $texto_inscricao_pos = $inscricao_pos->define_texto_inscricao();

    View::share('periodo_inscricao', $periodo_inscricao);

    View::share('texto_inscricao_pos', $texto_inscricao_pos);

        return view('livewire.lista-usuarios',
            [
                'users' => User::paginate($this->perPage)
            ])->extends('layouts.app')
        ->section('lista_usuarios');
    }
}
