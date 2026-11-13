<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Support\PhilippinePhone;

class TextBeeService
{
    protected string $apiKey;
    protected string $deviceId;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = (string) config('services.textbee.api_key');
        $this->deviceId = (string) config('services.textbee.device_id');
       $this->baseUrl = trim(
    rtrim(
        (string) config('services.textbee.base_url', 'https://api.textbee.dev'),
        '/'
    )
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

    /*
    |--------------------------------------------------------------------------
    | SMS Notifications module (send() above is kept unchanged for other callers)
    |--------------------------------------------------------------------------
    */

    /**
     * Submit one SMS and classify the outcome without guessing.
     *
     * outcome:
     * - accepted:      TextBee accepted the request (HTTP 2xx, not reported as failed).
     *                  This is NOT proof of delivery to the phone.
     * - rejected:      TextBee answered and refused it (e.g. 400/401/403/404/422/429).
     * - not_submitted: the request never reached TextBee (validation, configuration,
     *                  DNS failure or refused connection).
     * - unknown:       the request may have reached TextBee but no answer was
     *                  received (timeout, dropped connection, 5xx). Must not be
     *                  retried automatically.
     *
     * The returned error is safe to store: no credentials and no full numbers.
     *
     * @return array{outcome: string, batch_id: ?string, http_status: ?int, error: ?string, note: ?string}
     */
    public function submit(string $phoneNumber, string $message): array
    {
        $result = fn (string $outcome, ?string $error = null, ?int $status = null, ?string $batchId = null, ?string $note = null) => [
            'outcome' => $outcome,
            'batch_id' => $batchId,
            'http_status' => $status,
            'error' => $error === null ? null : self::safeText($error),
            'note' => $note === null ? null : self::safeText($note),
        ];

        $canonical = PhilippinePhone::normalize($phoneNumber);

        if ($canonical === null) {
            return $result('not_submitted', 'The recipient number is not a valid Philippine mobile number.');
        }

        if (trim($message) === '') {
            return $result('not_submitted', 'The SMS message is empty.');
        }

        if ($this->apiKey === '' || $this->deviceId === '') {
            return $result('not_submitted', 'The SMS gateway is not configured.');
        }

        try {
            $response = Http::timeout(30)
                ->connectTimeout(10)
                ->acceptJson()
                ->withHeaders(['x-api-key' => $this->apiKey])
                ->post("{$this->baseUrl}/api/v1/gateway/send-sms", [
                    'deviceId' => $this->deviceId,
                    'recipients' => ['+63' . substr($canonical, 1)],
                    'message' => trim($message),
                ]);
        } catch (ConnectionException $e) {
            // cURL 6 (could not resolve host), 7 (could not connect) and 35 (TLS
            // handshake failed) happen before the request is sent.
            if (preg_match('/cURL error (6|7|35)\b/', $e->getMessage())) {
                return $result('not_submitted', 'Could not reach TextBee. The request was not sent.');
            }

            return $result('unknown', 'No response from TextBee (connection timed out or was interrupted). TextBee may or may not have accepted the message.');
        } catch (\Throwable $e) {
            return $result('unknown', 'The request to TextBee was interrupted. TextBee may or may not have accepted the message.');
        }

        $status = $response->status();
        $json = $response->json();
        $data = is_array($json) ? ($json['data'] ?? $json) : [];
        $data = is_array($data) ? $data : [];

        if ($response->successful()) {
            $batchId = $data['smsBatchId'] ?? $data['batchId'] ?? $data['_id'] ?? null;
            $batchId = is_scalar($batchId) ? substr((string) $batchId, 0, 100) : null;
            $failed = ($data['success'] ?? null) === false
                || ((int) ($data['failureCount'] ?? 0) > 0 && (int) ($data['successCount'] ?? 0) === 0);

            if ($failed) {
                return $result('rejected', self::gatewayMessage($data, 'TextBee reported that the message could not be queued.'), $status, $batchId);
            }

            $warning = $data['warning']['message'] ?? null;

            return $result('accepted', null, $status, $batchId, is_string($warning) ? 'TextBee warning: ' . $warning : null);
        }

        if (in_array($status, [401, 403], true)) {
            return $result('rejected', "TextBee refused the gateway credentials (HTTP {$status}).", $status);
        }

        if ($status === 429) {
            return $result('rejected', 'TextBee rate limit reached (HTTP 429). The message was not queued.', $status);
        }

        if ($status >= 400 && $status < 500 && $status !== 408) {
            return $result('rejected', self::gatewayMessage(is_array($json) ? $json : [], "TextBee rejected the request (HTTP {$status})."), $status);
        }

        return $result('unknown', "TextBee returned HTTP {$status}. It may or may not have accepted the message.", $status);
    }

    /**
     * Look up a batch on TextBee. Only statuses TextBee itself reports are returned.
     *
     * @return array{ok: bool, status: ?string, error: ?string}
     */
    public function batchStatus(string $batchId): array
    {
        if ($this->apiKey === '' || $this->deviceId === '') {
            return ['ok' => false, 'status' => null, 'error' => 'The SMS gateway is not configured.'];
        }

        try {
            $response = Http::timeout(15)
                ->connectTimeout(10)
                ->acceptJson()
                ->withHeaders(['x-api-key' => $this->apiKey])
                ->get("{$this->baseUrl}/api/v1/gateway/devices/" . rawurlencode($this->deviceId) . '/sms-batch/' . rawurlencode($batchId));
        } catch (\Throwable $e) {
            return ['ok' => false, 'status' => null, 'error' => 'Could not reach TextBee to check the status.'];
        }

        if (! $response->successful()) {
            return ['ok' => false, 'status' => null, 'error' => "TextBee status lookup failed (HTTP {$response->status()})."];
        }

        $json = $response->json();
        $messages = data_get($json, 'data.messages') ?? data_get($json, 'messages') ?? data_get($json, 'data.smsList') ?? [];
        $statuses = collect(is_array($messages) ? $messages : [])
            ->map(fn ($m) => is_array($m) ? strtolower((string) ($m['status'] ?? '')) : '')
            ->filter()
            ->values();

        if ($statuses->isEmpty()) {
            $single = data_get($json, 'data.status') ?? data_get($json, 'data.batch.status') ?? data_get($json, 'status');
            if (is_string($single) && $single !== '') {
                $statuses = collect([strtolower($single)]);
            }
        }

        $known = ['pending', 'dispatched', 'sent', 'delivered', 'failed', 'unknown'];

        $status = match (true) {
            $statuses->isEmpty() => null,
            $statuses->contains('failed') => 'failed',
            $statuses->every(fn ($s) => $s === 'delivered') => 'delivered',
            $statuses->contains('sent') || $statuses->contains('delivered') => 'sent',
            $statuses->contains('dispatched') => 'dispatched',
            $statuses->contains('pending') => 'pending',
            default => in_array($statuses->first(), $known, true) ? $statuses->first() : 'unknown',
        };

        return $status === null
            ? ['ok' => false, 'status' => null, 'error' => 'TextBee did not report a status for this batch.']
            : ['ok' => true, 'status' => $status, 'error' => null];
    }

    /** Gateway error text, if it is a plain string. */
    private static function gatewayMessage(array $data, string $fallback): string
    {
        $text = $data['error'] ?? $data['message'] ?? null;

        if (is_array($text)) {
            $text = $text['message'] ?? null;
        }

        return is_string($text) && trim($text) !== '' ? 'TextBee: ' . trim($text) : $fallback;
    }

    /** Remove anything that looks like a phone number or key; cap the length. */
    public static function safeText(string $text): string
    {
        $text = preg_replace('/\+?\d[\d\s\-().]{5,}\d/', '[number hidden]', $text);
        $text = preg_replace('/\b[A-Za-z0-9_\-]{32,}\b/', '[hidden]', (string) $text);

        return mb_substr(trim((string) $text), 0, 300);
    }
}