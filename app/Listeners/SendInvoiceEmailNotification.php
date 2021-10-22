<?php

namespace App\Listeners;

use App\Mail\InvoiceMail;
use App\Models\BoatDates;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvoiceEmailNotification
{
    /**
     * Handle the event.
     *
     * @param  BoatDates $event
     * @return void
     */
    public function handle(BoatDates $event)
    {
        return Mail::send(new InvoiceMail($event));
    }
}
