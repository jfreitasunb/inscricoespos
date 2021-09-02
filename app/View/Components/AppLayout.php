<?php

namespace App\View\Components;

use Illuminate\View\Component;

use Illuminate\Support\Facades\App;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $idioma = App::getLocale();

        return view('layouts.app')->with('idioma', $idioma);
    }
}
