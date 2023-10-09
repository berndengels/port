<?php

namespace App\Mail;

use Illuminate\Notifications\Messages\MailMessage;

class CustomerMailMessage extends MailMessage
{
	public $markdown = 'vendor.notifications.admin.email';
	public $from = [];
}