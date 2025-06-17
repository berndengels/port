<?php

namespace App\Libs;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class EpWebhookResponse implements RespondsToWebhook
{
	public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
	{
		return response()->json([
			'message'	=> 'ok',
			'data'	=> $request->getContent(),
		]);
	}
}