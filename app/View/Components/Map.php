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
    protected $view;
    protected $viewParams = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lat = config('port.map.lat');
        $this->lng = config('port.map.lng');
        $this->zoom = config('port.map.zoom');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view($this->view, $this->viewParams);
    }
}
