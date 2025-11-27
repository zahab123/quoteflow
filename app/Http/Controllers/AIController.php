<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;

class AIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function generateQuotation(Request $request)
    {
        $title = $request->input('title');

        if (!$title || empty(trim($title))) {
            return response()->json([
                'success' => false,
                'error' => 'Title is required'
            ], 400);
        }

        try {
            $description = $this->openAIService->generateQuotation(trim($title));

            return response()->json([
                'success' => true,
                'description' => $description
            ]);

        } catch (\Exception $e) {
            \Log::error("AI Controller Error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate AI description: ' . $e->getMessage()
            ], 500);
        }
    }
}