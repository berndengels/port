<?php

namespace App\View\Components;

use Closure;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class HeaderNavigation extends Component
{
    public $currentRouteName;
    public $currentRoute;
    public $currentTopRouteName;
    public $currentRoutes;
    protected $subActions = ['show','edit','update','create','store','destroy'];
    public $subRoutes = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->currentRoute         = Route::current();
        $this->currentTopRouteName  = $request->session()->get('currentTopRouteName');
        $this->currentRoutes        = $request->session()->get('currentRoutes') ?? [];
        $this->currentRouteName     = $this->currentRoute->getName();
        $this->subActions           = collect($this->subActions);

        [$prefix, $controllerPrefix,] = explode('.', $this->currentRouteName);
        $this->subRoutes[$this->currentTopRouteName] = collect([$this->currentTopRouteName]);

        $subs = $this->subActions->map(fn($action) => "{$prefix}.{$controllerPrefix}.{$action}");
        foreach($subs as $sub) {
            $this->subRoutes[$this->currentTopRouteName]->push($sub);
        }
        $this->subRoutes[$this->currentTopRouteName] = $this->subRoutes[$this->currentTopRouteName]->keyBy(fn($v) => $v);
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
