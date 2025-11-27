<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    public function generateQuotation(string $title): string
    {
        // Get API key from environment
        $apiKey = env('GEMINI_API_KEY');
        
        // Log for debugging (without exposing full key)
        Log::info('Gemini API Key Check', [
            'key_exists' => !empty($apiKey),
            'key_length' => $apiKey ? strlen($apiKey) : 0
        ]);

        if (empty($apiKey) || $apiKey === 'your_new_api_key_here') {
            Log::error('Gemini API key not configured');
            return "AI service is not configured. Please contact administrator.";
        }

        $model = 'gemini-1.5-flash';
        $apiUrl = "https://generativelanguage.googleapis.com/v1/models/{$model}:generateContent?key={$apiKey}";

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => "Write a professional quotation description for: \"$title\". Keep it concise (3-4 sentences) and business-focused."]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.4,
                "maxOutputTokens" => 300,
            ]
        ];

        try {
            Log::info('Sending request to Gemini API', ['title' => $title]);
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($apiUrl, $payload);

            Log::info('Gemini API response status', ['status' => $response->status()]);

            if (!$response->successful()) {
                Log::error('Gemini API error', [
                    'status' => $response->status(),
                    'error' => $response->body()
                ]);
                return "AI service is temporarily unavailable. Please try again later.";
            }

            $data = $response->json();
            
            // Debug the response structure
            Log::info('Gemini API full response', ['data' => $data]);

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $description = trim($data['candidates'][0]['content']['parts'][0]['text']);
                Log::info('Successfully generated description');
                return $description;
            }

            Log::warning('Unexpected response structure from Gemini API', ['data' => $data]);
            return 'Unable to generate description at this time. Please try again.';

        } catch (\Exception $e) {
            Log::error('Gemini API exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return "Service temporarily unavailable. Please try again.";
        }
    }
}