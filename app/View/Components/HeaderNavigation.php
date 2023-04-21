<?php

namespace App\View\Components;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class HeaderNavigation extends Component
{
    public $currentRoute;
    public $currentTopRoute;
    public $currentRoutes;
    public $subRoutes = [];
    protected $subActions = ['show','edit','update','create','store','destroy'];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $guard, Request $request)
    {
        $this->currentRoute     = Route::current()->getName();
        $this->currentTopRoute  = $request->session()->get('currentTopRoute');
        $this->currentRoutes    = $request->session()->get('currentRoutes') ?? [];
        $this->subActions       = collect($this->subActions);

        $arr = explode('.', $this->currentRoute);

        if(count($arr) > 1) {
            [$prefix, $controllerPrefix,] = $arr;
            $this->subRoutes[$this->currentTopRoute] = collect([$this->currentTopRoute]);

            $subs = $this->subActions->map(fn($action) => "{$prefix}.{$controllerPrefix}.{$action}");
            foreach($subs as $sub) {
                $this->subRoutes[$this->currentTopRoute]->push($sub);
            }
            $this->subRoutes[$this->currentTopRoute] = $this->subRoutes[$this->currentTopRoute]->keyBy(fn($v) => $v);
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
