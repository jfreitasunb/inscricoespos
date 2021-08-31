<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TelaHome extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $idioma;

    public function __construct($idioma)
    {
        $this->idioma = $idioma;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tela-home');
    }
}
