<?php

namespace App\View\Components;

use App\Models\AdminUser;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminMainNavigation extends Component
{
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * @var $user AdminUser
         */
        $user = auth('admin')->user();
        $items = collect(config('port.menu.admin.items'))
            ->filter(function ($item) use ($user) {
//                return (!isset($item['permissions']) || (isset($item['permissions']) && $user->can($item['permissions'])));
                return (!isset($item['permissions']) || (isset($item['permissions'])));
            })
        ;

        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('components.admin-main-navigation');
    }
}
