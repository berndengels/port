<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Contact as ContactModel;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public ContactModel $contact)
    {
        $this->mailer = config('mail.mailer');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to(config('settings')->email)
            ->from($this->contact->email)
            ->subject($this->subject)
            ->markdown('markdown.contact', [
                'contact'   => $this->contact,
            ]);
    }
}
