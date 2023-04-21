<?php

namespace App\View\Components\Invoice;

class Prices extends Main
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public \stdClass $prices) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.invoice.prices');
    }
}
