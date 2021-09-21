<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public $item;
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $item = null)
    {
        $this->name = $name;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.menu-item', [
            'name' => $this->name,
            'item' => $this->item,
        ]);
    }
}
