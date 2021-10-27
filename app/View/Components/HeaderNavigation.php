<?php

namespace App\View\Components;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class HeaderNavigation extends Component
{
    public $items;
    public $current;
    public $currentSubRoute;
    protected $subActions = ['show','edit','update','create','store','destroy'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->items = $request->session()->get('currentRoutes') ?? [];
        $this->current = Route::current()->getName();
        [$prefix, $controllerPrefix, $action] = explode('.', $this->current);

        if(in_array($action, $this->subActions)) {
            $this->currentSubRoute = "{$prefix}.{$controllerPrefix}.{$action}";
            dump($this->currentSubRoute);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.header-navigation');
    }
}
