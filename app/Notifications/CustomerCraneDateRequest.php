<?php

namespace App\Notifications;

use App\Mail\CustomerMailMessage;
use App\Models\CraneDate;
use Illuminate\Bus\Queueable;

//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

class CustomerCraneDateRequest extends Notification
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
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via(object $notifiable)
	{
		return $notifiable->fon ? ['vonage', 'mail'] : ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return MailMessage
	 */
	public function toMail($notifiable)
	{
		$header = $this->getHeaderByMode();
		return (new CustomerMailMessage())
			->subject($header)
			->greeting('Hallo ' . $notifiable->name)
			->line($header)
//			->action('Krane-Termin Anfrage', route('admin.craneDates.index'))
			->line('Datum: ' . $this->craneDate->date->isoFormat('dddd D.M.Y'))
			->line('Zeit: ' . $this->craneDate->date->format('H.i') . ' Uhr')
			->line('Boot: ' . $this->craneDate->cranable->name)
			->line('Eigner: ' . $this->customer->name)
			->salutation('Beste Grüsse, ' . $this->customer->name)
			->markdown('vendor.notifications.admin.email');
	}

	/**
	 * Get the Vonage / SMS representation of the notification.
	 */
	public function toVonage(object $notifiable): VonageMessage
	{
		$content = $this->getMsgByMode();
		return (new VonageMessage)
			->clientReference((string)$this->customer->id)
			->content($content)
			->from($this->customer->fon)
			->unicode();
	}

	private function getMsgByMode()
	{
		$msg = $this->getHeaderByMode();
		$date = $this->craneDate->date->isoFormat('dddd D.M.Y');
		$time = $this->craneDate->date->format('H.i');
		$boat = $this->craneDate->cranable->name;

		return "$msg\nBoot: $boat\nDatum: $date\nUhrzeit: $time Uhr";
	}

	private function getHeaderByMode()
	{
		switch ($this->mode) {
			case 'store':
				return 'Neue Kran-Termin-Anfrage.';
			case 'update':
				return 'Kran-Termin-Anfrage wurde geändert.';
			case 'destroy':
				return 'Kran-Termin-Anfrage gelöscht.';
		}
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
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
