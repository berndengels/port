<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected Customer $customer)
    {
        $this->mailer = config('mail.mailer');
        $this->to[] = [
            'name'      => $customer->name,
            'address'   => $customer->email,
        ];
        $this->from[] = [
            'name'      => $customer->name,
            'address'   => $customer->email,
        ];
        $this->subject("Registrierung von $customer->name ($customer->email) erfolgreich");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->mailer($this->mailer)
            ->markdown(
            'markdown/customer-register', [
                'customer'  => $this->customer,
                'settings'  => config('settings'),
            ]
        );
    }
}
