<?php

namespace App\Listeners;

use App\Events\ServiceRequested;
use App\Models\AdminUser;
use App\Models\Permission;
use App\Notifications\NewServiceRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ServiceRequestNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ServiceRequested $event)
    {
        $query = AdminUser::permission(['confirm Registration']);
        if(! app()->environment('production')) {
            $query->whereEmail('engels@f50.de');
        }
        $user = $query->get();
//        dd($user->toArray());
        $user->each(fn(AdminUser $user) => $user->notify(new NewServiceRequest($event->serviceRequest, $event->mode)));
    }
}
