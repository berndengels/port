<?php

namespace App\Listeners;

use App\Mail\RegisterMail;
use App\Models\AdminUser;
use App\Notifications\NewRegistrationDone;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class SendRegisterEmailNotification extends SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $query = AdminUser::permission(['confirm Registration']);
        if(! app()->environment('production')) {
            $query->whereEmail('engels@f50.de');
        }
        $user = $query->get();
        $user->each(fn(AdminUser $user) => $user->notify(new NewRegistrationDone($event->user)));
//        return Mail::send(new RegisterMail($event->user));
    }
}
