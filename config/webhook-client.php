<?php

use App\Jobs\ProcessEpWebhookJob;
use App\Models\EpWebhookCall;
use App\Libs\EpWebhookResponse;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;
use Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo;

return [
    'configs' => [
        [
            /*
             * This package supports multiple webhook receiving endpoints. If you only have
             * one endpoint receiving webhooks, you can use 'default'.
             */
            'name' => 'default',
            /*
             * We expect that every webhook call will be signed using a secret. This secret
             * is used to verify that the payload has not been tampered with.
             */
            'signing_secret' => config('port.main.webhook.secret'),
            /*
             * The name of the header containing the signature.
             */
            'signature_header_name' => config('port.main.webhook.header'),
            /*
             *  This class will verify that the content of the signature header is valid.
             *
             * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
             */
            'signature_validator' => DefaultSignatureValidator::class,
            /*
             * This class determines if the webhook call should be stored and processed.
             */
            'webhook_profile' => ProcessEverythingWebhookProfile::class,
            /*
             * This class determines the response on a valid webhook call.
             */
            'webhook_response' => DefaultRespondsTo::class,
//			'webhook_response' => EpWebhookResponse::class,
            /*
             * The classname of the model to be used to store webhook calls. The class should
             * be equal or extend Spatie\WebhookClient\Models\WebhookCall.
             */
//            'webhook_model' => WebhookCall::class,
			'webhook_model' => EpWebhookCall::class,
            /*
             * In this array, you can pass the headers that should be stored on
             * the webhook call model when a webhook comes in.
             *
             * To store all headers, set this value to `*`.
             */
            'store_headers' => ['*'],
            /*
             * The class name of the job that will process the webhook request.
             *
             * This should be set to a class that extends \Spatie\WebhookClient\Jobs\ProcessWebhookJob.
             */
            'process_webhook_job' => ProcessEpWebhookJob::class,
//			'process_webhook_job' => '',
        ],
    ],
    /*
     * The integer amount of days after which models should be deleted.
     *
     * It deletes all records after 30 days. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,
    /*
     * Should a unique token be added to the route name
     */
    'add_unique_token_to_route_name' => false,
];
