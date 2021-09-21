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
    protected $viewParams;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(float $lat, float $lng, int $zoom)
    {
        $this->lat  = $lat;
        $this->lng  = $lng;
        $this->zoom = $zoom;
        $this->viewParams = [
            'lat'   => $this->lat,
            'lng'   => $this->lng,
            'zoom'   => $this->zoom,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    function render() {
        return view($this->view, $this->viewParams);
    }
}
