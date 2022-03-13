<?php

namespace App\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;
use App\Models\Site;

class LocationCreatedWebhookJob extends SpatieProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall; // contains an instance of `WebhookCall`
        // perform the work here
        $data = json_decode($this->webhookCall, true);
        \Log::info($data);
        $location_id = $data["location_id"];
        $merchant_id = $data["merchant_id"];

        http_response_code(200); //Acknowledge you received the response
    }
}