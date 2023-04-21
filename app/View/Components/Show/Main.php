<?php

namespace App\View\Components\Show;

use Illuminate\View\Component;

abstract class Main extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public \stdClass $prices)
    {
        //
    }
}
