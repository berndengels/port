<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchFilter extends Component
{
    public $name;
    public $label;
    public $placeholder;
    public $method = 'get';
    public $action;
    public $options;
    public $css;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, string $action, string $label = '', string $placeholder = '',array $options = null, string $method = null, string $css = '')
    {
        $this->name     = $name;
        $this->action   = $action;
        $this->label    = $label;
        $this->placeholder = $placeholder;
        $this->options  = $options;
        if($method) {
            $this->method = $method;
        }
        $this->css = $css;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.search-filter');
    }
}
