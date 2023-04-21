<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public $currentRouteName;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $guard,
        public $item = null,
        public $icon = null,
        public $route = null,
        public $class = null,
    ) {
        $this->currentRouteName = session()->get('currentRoute');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.menu-item');
    }
}
