<?php

namespace App\Listeners;

use App\Mail\RegisterMail;
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
        return Mail::send(new RegisterMail($event->user));
    }
}
