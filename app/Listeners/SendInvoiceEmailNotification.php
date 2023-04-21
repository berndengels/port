<?php

namespace App\Listeners;

use App\Mail\InvoiceMail;
use App\Models\BoatDates;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Vonage\Client\Credentials\Basic;
use Vonage\Client;

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
/*
        $basic  = new Basic(env('NEXMO_KEY'), env('NEXMO_SECRET'));
        $client = new Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("491791014302", BRAND_NAME, 'A text message sent using the Nexmo SMS API')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
*/
        return Mail::send(new InvoiceMail($event));
    }
}
