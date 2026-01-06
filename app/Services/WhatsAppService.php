<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $provider;
    private array $config;

    public function __construct()
    {
        $this->provider = config('whatsapp.provider', 'log');
        $this->config = config('whatsapp');
    }

    /**
     * Send a message to a WhatsApp group.
     */
    public function sendToGroup(string $groupId, string $message): array
    {
        return match($this->provider) {
            'fonnte' => $this->sendViaFonnte($groupId, $message),
            'log' => $this->sendViaLog($groupId, $message),
            default => $this->sendViaLog($groupId, $message),
        };
    }

    /**
     * Send message via Fonnte API.
     * 
     * @see https://fonnte.com/api-doc
     */
    private function sendViaFonnte(string $groupId, string $message): array
    {
        $token = $this->config['fonnte']['token'] ?? '';
        $url = $this->config['fonnte']['url'] ?? 'https://api.fonnte.com/send';

        if (empty($token)) {
            Log::warning('WhatsApp: Fonnte token not configured');
            return [
                'success' => false,
                'message' => 'Fonnte token not configured',
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post($url, [
                'target' => $groupId,
                'message' => $message,
                'countryCode' => '62',
            ]);

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                Log::info("WhatsApp: Message sent to group {$groupId}");
                return [
                    'success' => true,
                    'message' => 'Message sent successfully',
                    'response' => $result,
                ];
            }

            Log::warning("WhatsApp: Failed to send message", [
                'group_id' => $groupId,
                'response' => $result,
            ]);

            return [
                'success' => false,
                'message' => $result['reason'] ?? 'Unknown error',
                'response' => $result,
            ];

        } catch (\Exception $e) {
            Log::error("WhatsApp: Exception while sending message", [
                'group_id' => $groupId,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Log message instead of sending (for testing).
     */
    private function sendViaLog(string $groupId, string $message): array
    {
        Log::info("WhatsApp [LOG MODE]: Would send to group {$groupId}", [
            'message' => $message,
        ]);

        return [
            'success' => true,
            'message' => 'Logged (not sent)',
            'mode' => 'log',
        ];
    }

    /**
     * Check if the service is properly configured.
     */
    public function isConfigured(): bool
    {
        if ($this->provider === 'log') {
            return true;
        }

        if ($this->provider === 'fonnte') {
            return !empty($this->config['fonnte']['token']);
        }

        return false;
    }

    /**
     * Get the current provider name.
     */
    public function getProvider(): string
    {
        return $this->provider;
    }
}
