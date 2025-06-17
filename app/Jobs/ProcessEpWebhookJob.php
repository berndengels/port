<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;
class ProcessEpWebhookJob extends SpatieProcessWebhookJob
{
    use Dispatchable;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		// $this->webhookCall // contains an instance of `WebhookCall`
		// perform the work here
		return $this->webhookCall;
	}
}
