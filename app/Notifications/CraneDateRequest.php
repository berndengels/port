<?php

namespace App\Notifications;

use App\Models\CraneDate;
use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class CraneDateRequest extends Notification
{
    use Queueable;
	private $customer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public CraneDate $craneDate, public string $mode)
    {
        $this->customer = $this->craneDate->cranable->customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable)
    {
//        return $notifiable->fon ? ['vonage'] : ['mail'];
        return ['vonage'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
			->line('The introduction to the notification.')
			->action('Notification Action', url('/'))
			->line('Thank you for using our application!');
    }

	/**
	 * Get the Vonage / SMS representation of the notification.
	 */
	public function toVonage(object $notifiable): VonageMessage
	{
		$content = $this->getMsgByMode();
		return (new VonageMessage)
//			->clientReference((string) $notifiable->customer->id)
			->content($content)
			->from($this->customer->fon)
			->unicode();
	}

	private function getMsgByMode()
	{
		switch ($this->mode) {
			case 'store':
				$msg = 'Neue Kran-Termin-Anfrage.';
				break;
			case 'update':
				$msg = 'Kran-Termin-Anfrage wurde geändert.';
				break;
			case 'destroy':
				$msg = 'Kran-Termin-Anfrage gelöscht.';
				break;
		}
		$date = $this->craneDate->date->format('d.m.Y');
		$time = $this->craneDate->date->format('H.i');
		$boat = app($this->craneDate->cranable_type)->find($this->craneDate->cranable_id);
		$name = $boat ? $boat->name : null;
		return "$msg\nBoot: $name\nDatum: $date\nUhrzeit: $time\n\n";
	}

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

	public function getCustomer(): mixed
	{
		return $this->customer;
	}
}
