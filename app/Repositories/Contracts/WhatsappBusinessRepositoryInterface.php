<?php

namespace App\Repositories\Contracts;

interface WhatsappBusinessRepositoryInterface
{
    public function sendMessage(string $apiVersion, string $phoneNumberId, string $accessToken, array $payload): array;

    public function markAsRead(string $apiVersion, string $phoneNumberId, string $accessToken, string $messageId): array;

    public function uploadMedia(
        string $apiVersion,
        string $phoneNumberId,
        string $accessToken,
        string $filePath,
        string $mimeType,
        string $fileName
    ): array;

    public function getMediaInfo(string $apiVersion, string $accessToken, string $mediaId): array;

    public function downloadMedia(string $accessToken, string $url): string;
}
