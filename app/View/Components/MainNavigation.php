<?php

namespace App\View\Components;

use Closure;
use App\Models\AdminUser;
use App\Models\Customer;
use Detection\MobileDetect;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MainNavigation extends Component
{
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public string $guard)
    {
        /**
         * @var $user AdminUser|Customer
         */
        $user = auth($this->guard)->user();
        $isMobile = (new MobileDetect())->isMobile();
        $this->items = collect([]);
        if($user) {
            $this->items = collect(config('port.menu.'.$this->guard.'.items'))
                ->filter(fn ($item) => (!isset($item['permissions'])
                    || (isset($item['permissions']) && $user->can($item['permissions']))
//                    && ($isMobile && false === $item['hide_on_mobile'])
                ))
            ;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.main-navigation');
    }
}
