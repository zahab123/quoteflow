<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;

class AIController extends Controller
{
    public function generateQuotation(Request $request, OpenAIService $openAI)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $description = $openAI->generateQuotation($request->title);

        return response()->json(['description' => $description]);
    }
}
