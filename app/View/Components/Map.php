<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class Map extends Component
{
    public $lat;
    public $lng;
    public $zoom;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lat  = env('MIX_POSITION_LAT');
        $this->lng  = env('MIX_POSITION_LNG');
        $this->zoom = env('MIX_POSITION_ZOOM');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    function render()
    {
        return view($this->view);
    }
}
