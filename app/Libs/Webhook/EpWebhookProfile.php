<?php

namespace App\Libs\Webhook;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class EpWebhookProfile implements WebhookProfile
{
	public function shouldProcess(Request $request): bool
	{
		return true;
	}
}