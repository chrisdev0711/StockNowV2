<?php

namespace App\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class LocationUpdatedWebhookJob extends SpatieProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall; // contains an instance of `WebhookCall`
        // perform the work here
        $data = json_decode($this->webhookCall, true);
        \Log::info($data);
        http_response_code(200); //Acknowledge you received the response
    }
}