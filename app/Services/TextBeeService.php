<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextBeeService
{
    protected string $apiKey;
    protected string $deviceId;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.textbee.api_key');
        $this->deviceId = config('services.textbee.device_id');
        $this->baseUrl = config('services.textbee.base_url');
    }

    /**
     * Send SMS using TextBee
     */
    public function send(string $phoneNumber, string $message): array
    {
        // Convert Philippine local number (09xxxxxxxxx) to E.164 (+639xxxxxxxxx)
        if (str_starts_with($phoneNumber, '09')) {
            $phoneNumber = '+63' . substr($phoneNumber, 1);
        }

        try {

    $response = Http::withHeaders([
        'x-api-key' => $this->apiKey,
        'Content-Type' => 'application/json',
    ])->post(
        "{$this->baseUrl}/gateway/devices/{$this->deviceId}/send-sms",
        [
            'recipients' => [$phoneNumber],
            'message' => $message,
        ]
    );

} catch (\Exception $e) {

    return [
        'success' => false,
        'error' => $e->getMessage(),
    ];

}

       if ($response->successful()) {
    return [
        'success' => true,
        'data' => $response->json(),
    ];
}

return [
    'success' => false,
    'status' => $response->status(),
    'error' => $response->json() ?: $response->body(),
];
    }
}