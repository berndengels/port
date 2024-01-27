<?php

namespace App\View\Components;

use Closure;
use App\Models\AdminUser;
use App\Models\Customer;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Sidebar extends Component
{
    public $items;
	public $user;
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
        $this->user = auth($this->guard)->user();
        $this->items = collect([]);
        $configKey = $this->guard;

        if('customer' === $this->guard) {
            switch ($this->user->type) {
                case 'guest':
                case 'permanent':
                    $configKey = $this->guard.'.boat';
                    break;
                case 'renter':
                    $configKey = $this->guard.'.renter';
                    break;
            }
        }

        if($this->user) {
            $this->items = collect(config('port.menu.'.$configKey.'.items'))
				->filter(fn ($item, $name) => $item && !isset($item['permissions']) || ($item && isset($item['permissions']) && $this->user->can($item['permissions'])))
				->toArray()
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
        return view('components.sidebar', [
			'items' => $this->items,
			'user'	=> $this->user,
		]);
    }
}
