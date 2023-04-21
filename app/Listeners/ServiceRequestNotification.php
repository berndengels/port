<?php

namespace App\Listeners;

use App\Events\ServiceRequested;
use App\Models\AdminUser;
use App\Models\Customer;
use App\Notifications\NewServiceRequest;
//use Illuminate\Http\Client\Request;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isInstanceOf;

class ServiceRequestNotification
{
    private $user;
    private $guard;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
        if($this->user instanceof AdminUser) {
            $this->guard = 'admin';
        } elseif ($this->user instanceof Customer) {
            $this->guard = 'customer';
        }
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ServiceRequested $event)
    {
        if('admin' === $this->guard) {
            $customer = $event->serviceRequest->boat->customer;
            $customer->notify(new NewServiceRequest($event->serviceRequest, $event->mode));
        } else {
            $query = AdminUser::permission(['confirm Registration']);
            if(! app()->environment('production')) {
                $query->whereEmail('engels@f50.de');
            }
            $user = $query->get();
            $user->each(fn(AdminUser $user) => $user->notify(new NewServiceRequest($event->serviceRequest, $event->mode)));
        }
    }
}
