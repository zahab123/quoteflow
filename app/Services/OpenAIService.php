<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public function generateQuotation(string $title): string
    {
        $prompt = "Write a professional business quotation description for the title: \"$title\"";

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an assistant that writes professional business quotations.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

        return $response['choices'][0]['message']['content'] ?? 'Failed to generate description.';
    }
}
