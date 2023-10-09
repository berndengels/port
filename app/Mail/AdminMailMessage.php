<?php

namespace App\Mail;

use Illuminate\Notifications\Messages\MailMessage;

class AdminMailMessage extends MailMessage
{
	public $markdown = 'vendor.notifications.admin.email';
	public $from = [];
}