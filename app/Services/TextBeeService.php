<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class TextBeeService
{
    protected string $apiKey;
    protected string $deviceId;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = (string) config('services.textbee.api_key');
        $this->deviceId = (string) config('services.textbee.device_id');
        $this->baseUrl = rtrim(
            (string) config('services.textbee.base_url', 'https://api.textbee.dev'),
            '/'
        );
    }

    /**
     * Send an SMS using TextBee.
     *
     * Philippine local format:
     * 09xxxxxxxxx
     *
     * Converted to E.164:
     * +639xxxxxxxxx
     */
    public function send(string $phoneNumber, string $message): array
    {
        $phoneNumber = trim($phoneNumber);
        $message = trim($message);

        // Basic validation
        if ($phoneNumber === '') {
            return [
                'success' => false,
                'error' => 'Recipient phone number is empty.',
            ];
        }

        if ($message === '') {
            return [
                'success' => false,
                'error' => 'SMS message is empty.',
            ];
        }

        // Convert Philippine local number:
        // 09171234567 -> +639171234567
        if (str_starts_with($phoneNumber, '09')) {
            $phoneNumber = '+63' . substr($phoneNumber, 1);
        }

        // Keep +639..., +44..., etc. as they are.
        // TextBee expects international/E.164 format.
        if (!str_starts_with($phoneNumber, '+')) {
            return [
                'success' => false,
                'error' => 'Phone number must be in international format, e.g. +639171234567.',
            ];
        }

        // Make sure required TextBee configuration exists.
        if ($this->apiKey === '') {
            return [
                'success' => false,
                'error' => 'TextBee API key is not configured.',
            ];
        }

        if ($this->deviceId === '') {
            return [
                'success' => false,
                'error' => 'TextBee device ID is not configured.',
            ];
        }

        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->withHeaders([
                    'x-api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    "{$this->baseUrl}/api/v1/gateway/send-sms",
                    [
                        'deviceId' => $this->deviceId,
                        'recipients' => [$phoneNumber],
                        'message' => $message,
                    ]
                );

        } catch (ConnectionException $e) {
            return [
                'success' => false,
                'error' => 'Unable to connect to TextBee.',
                'details' => $e->getMessage(),
            ];
        }
        catch (\Throwable $e) {

    \Log::error('TEXTBEE EXCEPTION', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ]);

    return [
        'success' => false,
        'error' => $e->getMessage(),
    ];
}

        $responseData = $response->json();

        // TextBee accepted the request.
        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $responseData,
                'status' => $response->status(),
            ];
        }

        // TextBee rejected the request.
        return [
            'success' => false,
            'status' => $response->status(),
            'error' => is_array($responseData)
                ? ($responseData['error'] ?? $responseData['message'] ?? 'TextBee rejected the SMS request.')
                : ($response->body() ?: 'TextBee rejected the SMS request.'),
            'data' => $responseData,
        ];
    }
}