<?php

namespace App\Http\Services\WhatsApp;

use GuzzleHttp\Client;

class WhatsAppService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.whatsapp.url'),
            'timeout' => 120,
        ]);
    }

    /**
     * Generate HMAC Headers
     */
    function generateHmacHeaders(string $body): array
    {
        $timestamp = time();
        $secretKey = config('services.whatsapp.hmac_secret_key');
        $publicKey = config('services.whatsapp.hmac_public_key');

        $token = hash_hmac('sha256', $body . $timestamp, $secretKey);

        return [
            'X-key' => $publicKey,
            'X-timestamp' => $timestamp,
            'X-token' => $token,
        ];
    }

    /**
     * Universal Request Handler (Auto HMAC)
     */
    private function sendRequest(string $endpoint, array $payload = [], string $method = 'POST'): array
    {
        $body = $method === 'GET' ? '' : json_encode($payload, JSON_UNESCAPED_UNICODE);

        $headers = array_merge(
            $this->generateHmacHeaders($body),
            ['Content-Type' => 'application/json']
        );

        $options = ['headers' => $headers];

        if ($method === 'POST') {
            $options['body'] = $body;
        }

        $response = $this->client->request($method, $endpoint, $options);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function sendMessage(string $to, string $message): array
    {
        return $this->sendRequest('/api/whatsapp/send-message', [
            'to'      => $to,
            'message' => $message,
        ]);
    }

    public function getChats(): array
    {
        return $this->sendRequest('/api/whatsapp/chats', [], 'GET');
    }
}
