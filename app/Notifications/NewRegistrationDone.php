<?php

namespace App\Notifications;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewRegistrationDone extends Notification
{
    use Queueable;

    private $mailer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
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
//        return $notifiable->fon ? ['mail','nexmo'] : ['mail'];
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
        $message = (new MailMessage)
            ->mailer($this->mailer)
            ->subject('Neue Kunden Registrierung')
            ->markdown('markdown.register', [
                'customer' => $this->customer,
            ]);

        return $message;
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
/*
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Neue Kunden Registrierung für '.$this->customer->name.' ('.$this->customer->email.')')
            ->unicode()
            ;
    }
*/
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
