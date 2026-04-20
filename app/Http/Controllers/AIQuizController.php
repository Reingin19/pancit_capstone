<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIQuizController extends Controller
{
    public function generateModuleContent(Request $request)
    {
        // Kunin ang PDF URL mula sa request (galing sa Supabase)
        $pdfUrl = $request->input('pdf_url');
        $apiKey = env('GEMINI_API_KEY');

        // Ang detalyadong prompt para sa "CodeChum Style" content
        $prompt = "Act as an expert Math teacher. Analyze this learning module: $pdfUrl. 
        Create a JSON object with the following:
        1. 'pre_test': 20 multiple-choice questions (easy).
        2. 'main_content': A detailed summary of the main topic.
        3. 'post_test': 20 multiple-choice questions (hard).
        Format each question with 'question', 'options' (Array), and 'correct_answer' (String).";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json'
                ]
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Failed to reach AI API'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}