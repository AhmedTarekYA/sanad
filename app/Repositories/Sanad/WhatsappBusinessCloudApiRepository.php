<?php

namespace App\Repositories\Sanad;

use App\Repositories\Contracts\WhatsappBusinessRepositoryInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WhatsappBusinessCloudApiRepository implements WhatsappBusinessRepositoryInterface
{
    public function sendMessage(string $apiVersion, string $phoneNumberId, string $accessToken, array $payload): array
    {
        return $this->postJson($apiVersion, $phoneNumberId, $accessToken, 'messages', $payload);
    }

    public function markAsRead(string $apiVersion, string $phoneNumberId, string $accessToken, string $messageId): array
    {
        $payload = [
            'messaging_product' => 'whatsapp',
            'status' => 'read',
            'message_id' => $messageId,
        ];

        return $this->postJson($apiVersion, $phoneNumberId, $accessToken, 'messages', $payload);
    }

    public function uploadMedia(
        string $apiVersion,
        string $phoneNumberId,
        string $accessToken,
        string $filePath,
        string $mimeType,
        string $fileName
    ): array {
        $apiVersion = ltrim($apiVersion, '/');
        $url = 'https://graph.facebook.com/'.$apiVersion.'/'.$phoneNumberId.'/media';

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->timeout(30)
            ->attach('file', fopen($filePath, 'r'), $fileName, ['Content-Type' => $mimeType])
            ->post($url, [
                'messaging_product' => 'whatsapp',
                'type' => $mimeType,
            ]);

        return $this->parseJson($response, 'WhatsApp API upload');
    }

    protected function postJson(string $apiVersion, string $phoneNumberId, string $accessToken, string $path, array $payload): array
    {
        $apiVersion = ltrim($apiVersion, '/');
        $path = ltrim($path, '/');
        $url = 'https://graph.facebook.com/'.$apiVersion.'/'.$phoneNumberId.'/'.$path;

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->timeout(30)
            ->post($url, $payload);

        return $this->parseJson($response, 'WhatsApp API');
    }

    public function getMediaInfo(string $apiVersion, string $accessToken, string $mediaId): array
    {
        $apiVersion = ltrim($apiVersion, '/');
        $url = 'https://graph.facebook.com/'.$apiVersion.'/'.$mediaId;

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->timeout(30)
            ->get($url);

        return $this->parseJson($response, 'WhatsApp API get media info');
    }

    public function downloadMedia(string $accessToken, string $url): string
    {
        $response = Http::withToken($accessToken)
            ->timeout(30)
            ->get($url);

        if (! $response->successful()) {
            throw new RuntimeException('WhatsApp API download media error (HTTP '.$response->status().'): '.$response->body());
        }

        return $response->body();
    }

    protected function parseJson(Response $response, string $context): array
    {
        $statusCode = $response->status();
        $body = $response->body();
        $json = json_decode($body, true);

        if ($statusCode < 200 || $statusCode >= 300) {
            $apiMessage = is_array($json) ? ($json['error']['message'] ?? null) : null;
            $apiCode = is_array($json) ? ($json['error']['code'] ?? null) : null;
            $apiType = is_array($json) ? ($json['error']['type'] ?? null) : null;

            $details = [];
            if ($apiMessage) {
                $details[] = $apiMessage;
            }
            if ($apiType) {
                $details[] = $apiType;
            }
            if ($apiCode !== null) {
                $details[] = 'code='.$apiCode;
            }

            $extra = '';
            if (! empty($details)) {
                $extra = ' ('.implode(', ', $details).')';
            }

            throw new RuntimeException($context.' error (HTTP '.$statusCode.')'.$extra.': '.$body);
        }

        if (! is_array($json)) {
            throw new RuntimeException($context.' invalid JSON response: '.$body);
        }

        return $json;
    }
}
