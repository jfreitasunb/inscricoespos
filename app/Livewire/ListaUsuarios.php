<?php

namespace App\Livewire;

use Livewire\Component;

class ListaUsuarios extends Component
{
    public function render()
    {
        return view('livewire.lista-usuarios')
        ->extends('layouts.app')
        ->section('lista_usuarios');
    }
}
