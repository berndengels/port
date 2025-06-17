<?php

namespace App\Http\Controllers;

use App\Libs\EpWebhookResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Events\InvalidWebhookSignatureEvent;
use Spatie\WebhookClient\Models\WebhookCall;

class WebhookController extends Controller
{
	public function ep(Request $request)
	{
		$content = $request->getContent();
		$signatur = $request->header(config('port.main.webhook.header'));
		$hash = hash_hmac('sha256', $content, config('port.main.webhook.secret'));

		if($signatur === $hash) {
			$data = [
				'url'	=> $request->fullUrl(),
				'name'	=> $request->post('name'),
				'headers'	=> $request->headers,
				'payload'	=> $content,
				'exception'	=> null,
			];
			$data = WebhookCall::create($data);
			try {
				return (new EpWebhookResponse())->respondToValidWebhook($request);
			}
			catch (Exception $e) {
				Log::channel('webhook')->error($e->getMessage());
			}
//			return response()->json($data);
		} else {
			Event::dispatch(InvalidWebhookSignatureEvent::class);
		}
	}
}