<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;

class WebhookController extends Controller
{
	public function ep(Request $request)
	{
		$content = $request->getContent();
		$data	= json_decode($content);
		$signatur = $request->header(config('port.main.webhook.header'));
		$hash = hash_hmac('sha256', $content, config('port.main.webhook.secret'));

//		\File::put(storage_path('logs/data.json'), print_r($data, true));

		$data = [
			'object_id'	=> $request->post('id'),
			'name'		=> $request->post('name'),
			'action'	=> $data->action,
			'url'		=> $request->url(),
			'headers'	=> $request->headers,
			'payload'	=> $content,
//					'exception'	=> null,
		];

		if($signatur === $hash) {
			try {
				WebhookCall::create($data);
//				Log::channel('webhook')->info('signatur is valid');
			}
			catch (Exception $e) {
				Log::channel('webhook')->error($e->getMessage());
			}
		} else {
			Log::channel('webhook')->error('no valid signatur');
		}
	}
}