<?php

namespace App\View\Components\Invoice;

class GuestPrices extends Main
{
    public $netto;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public \stdClass $prices) {
        parent::__construct();
        if($this->settings->use_tax) {
            $this->netto = 1;
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.invoice.guest-prices');
    }
}
