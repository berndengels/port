<?php

namespace App\Listeners;

use App\Models\AdminUser;
use App\Mail\CustomerRegisterMail;
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
        // send mail to new registred customer
        Mail::mailer(config('mail.mailer'))->send(new CustomerRegisterMail($event->user));
        $query = AdminUser::permission(['confirm Registration']);
        if(! app()->environment('production')) {
            $query->whereEmail('engels@f50.de');
        }
        $user = $query->get();
        // send mails to admin users, for confirmation of new registration
        $user->each(fn(AdminUser $user) => $user->notify(new NewRegistrationDone($event->user)));
    }
}
