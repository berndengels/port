<?php

namespace App\Models;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;

class EpWebhookCall extends WebhookCall
{
    protected $table = 'webhook_calls';
    public $guarded = ['id'];

	public static function store(Request $request): EpWebhookCall
	{
		$content = $request->getContent();
		$data	= json_decode($content);
		$properties = config('webhook-client.configs')[0];
		$properties['name'] = $request->post('name');
		$headers = self::headersToStore(new WebhookConfig($properties), $request);

		return self::create([
			'object_id'	=> $request->post('id'),
			'name'		=> $request->post('name'),
			'action'	=> $data->action,
			'url' 		=> $request->fullUrl(),
			'headers'	=> $headers,
			'payload'	=> $request->input(),
			'exception'	=> null,
		]);
	}
}
