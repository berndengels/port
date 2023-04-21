<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Support\Facades\URL;

class RegistrationConfirmed extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $mailer;
    public function __construct(protected Customer $customer) {
        $this->mailer = config('mail.mailer');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function locale($locale)
    {
        return config('app.locale');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $url = URL::signedRoute('customer.signin', ['customerId' => $this->customer->id]);
        $message =  (new MailMessage)
            ->mailer($this->mailer)
            ->subject('Ihre Registrierung bei ' . config('app.name') . ' wurde bestätigt')
            ->markdown('markdown.register-confirmed', [
                'customer' => $this->customer,
                'url'   => $url,
            ]);

        return $message;
    }
}
