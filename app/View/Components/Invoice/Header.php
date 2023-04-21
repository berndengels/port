<?php

namespace App\View\Components\Invoice;

use App\Models\ConfigSetting;

class Header extends Main
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.invoice.header');
    }
}
