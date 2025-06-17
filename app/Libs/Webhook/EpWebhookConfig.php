<?php

namespace App\Libs\Webhook;

use Spatie\WebhookClient\WebhookConfig;

class EpWebhookConfig extends WebhookConfig
{
	public function __construct(array $properties = null)
	{
		$this->signatureHeaderName = config('port.main.webhook.header');
		$this->signingSecret = config('port.main.webhook.secret');

		parent::__construct($properties);
	}


}