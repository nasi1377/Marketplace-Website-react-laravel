<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-70b-versatile',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'تو یک دستیار هوشمند برای سایت فروش محصولات و دوره‌ها هستی.'
                ],
                [
                    'role' => 'user',
                    'content' => $request->message
                ]
            ]
        ]);

        return response()->json([
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);
    }
}