<?php

namespace App\Mail;

use Illuminate\Notifications\Messages\MailMessage;

class CustomerMailMessage extends MailMessage
{
	public $markdown = 'vendor.notifications.customer.email';
	public $from = [];
}