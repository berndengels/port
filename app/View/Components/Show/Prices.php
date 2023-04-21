<?php

namespace App\View\Components\Show;

class Prices extends Main
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.show.prices');
    }
}
