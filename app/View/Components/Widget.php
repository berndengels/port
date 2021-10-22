<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Widget extends Component
{
    public $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(object $data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.widget', ['data' => $this->data]);
    }
}
