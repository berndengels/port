<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewServiceRequest extends Notification
{
    use Queueable;

    private $mailer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected ServiceRequest $serviceRequest,
        protected string $mode
    ) {
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
        $mode = 'update' === $this->mode ? 'Geänderte' : 'Neue';
        $msg = "$mode Service Anfrage für ".$this->serviceRequest->boat->name;
        $message =  (new MailMessage())
            ->mailer($this->mailer)
            ->subject($msg)
            ->greeting($msg)
            ->action('Details', route('admin.serviceRequests.show', $this->serviceRequest))
        ;

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
