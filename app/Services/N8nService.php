<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\UsageLog;
use App\Models\Tool;
use App\Models\User;

class N8nService
{
    /**
     * Execute the n8n workflow for a specific tool.
     */
    public function executeTool(Tool $tool, User $user, array $inputs)
    {
        $webhookUrl = $tool->n8n_webhook_url;

        if (empty($webhookUrl)) {
            return [
                'status' => 'error',
                'message' => 'Tool configuration error: Webhook URL missing.'
            ];
        }

        // Prepare Payload
        $payload = [
            'toolId' => $tool->id,
            'userId' => $user->id,
            'timestamp' => now()->toIso8601String(),
            'inputs' => $inputs,
            'userContext' => [
                'email' => $user->email,
                'name' => $user->name,
                'subscription' => 'pro', // Mock
            ]
        ];

        // Create Pending Log
        $log = UsageLog::create([
            'user_id' => $user->id,
            'tool_id' => $tool->id,
            'input_data' => $inputs,
            'status' => 'pending',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'X-API-KEY' => env('N8N_API_KEY'),
                    'Content-Type' => 'application/json',
                ])
                ->post($webhookUrl, $payload);

            if ($response->successful()) {
                $data = $response->json();

                // Update Log
                $log->update([
                    'output_data' => $data,
                    'status' => 'success'
                ]);

                return $data;
            } else {
                Log::error("N8n Error for Tool {$tool->id}: " . $response->body());

                $log->update([
                    'output_data' => ['error' => $response->body()],
                    'status' => 'error'
                ]);

                return [
                    'status' => 'error',
                    'message' => 'External service error: ' . $response->status()
                ];
            }

        } catch (\Exception $e) {
            Log::error("N8n Exception for Tool {$tool->id}: " . $e->getMessage());

            $log->update([
                'output_data' => ['exception' => $e->getMessage()],
                'status' => 'error'
            ]);

            return [
                'status' => 'error',
                'message' => 'Service execution failed.'
            ];
        }
    }
}
