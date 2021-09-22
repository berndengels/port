<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component
{

    public $href;
    public $text;
    public $icon;
    public $class;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $href, string $text = null, string $icon = null, string $class = null, string $title = null)
    {
        $this->href     = $href;
        $this->text     = $text;
        $this->icon     = $icon;
        $this->class    = $class;
        $this->title    = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.nav-link');
    }
}
