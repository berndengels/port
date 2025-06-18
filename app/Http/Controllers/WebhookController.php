<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\EpWebhookCall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
	public function ep(Request $request)
	{
		$content = $request->getContent();
		$signatur = $request->header(config('port.main.webhook.header'));
		$hash = hash_hmac('sha256', $content, config('port.main.webhook.secret'));

//		\File::put(storage_path('logs/data.json'), print_r($request->post(), true));

		if($signatur === $hash) {
			try {
				EpWebhookCall::store($request);
//				Log::channel('webhook')->info('signatur is valid');
			}
			catch (Exception $e) {
				$msg = $e->getFile().' ('.$e->getLine().'): '.$e->getMessage().' code: '.$e->getCode();
				Log::channel('webhook')->error($msg);
			}
		} else {
			Log::channel('webhook')->error('no valid signatur');
		}
	}
}