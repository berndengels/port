<?php

namespace App\Libs\Webhook;

use Spatie\WebhookClient\WebhookConfig;

class EpWebhookConfig extends WebhookConfig
{
	public string $action;
	public function __construct(array $properties)
	{
		$this->signatureHeaderName = config('port.main.webhook.header');
		$this->signingSecret = config('port.main.webhook.secret');
		$this->action = $properties['action'];

		$properties = [
			...$properties,
			'signatureHeaderName'	=> config('port.main.webhook.header'),
			'signingSecret'	=> config('port.main.webhook.secret'),
			'action'	=> $properties['action'],
		];

		parent::__construct($properties);
	}
}