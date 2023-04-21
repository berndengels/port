<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Content extends Component
{
    public ?string $guard = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(auth('admin')->check()) {
            $this->guard = 'admin';
        } elseif (auth('customer')->check()) {
            $this->guard = 'customer';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.content');
    }
}
