<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatBotController extends Controller
{
    public function sendChat(Request $request){
        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $request->input],
                ],
                'max_tokens' => 100,
            ]);
        
            $response = $result->toArray()['choices'][0]['message']['content'] ?? '';
        
            return response()->json([
                'success' => true,
                'response' => trim($response),
            ]);
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            if (str_contains($e->getMessage(), 'quota')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have exceeded your API quota. Please check your plan or billing details.',
                ], 429); // 429 Too Many Requests
            }
        
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendChatBackup(Request $request){
        $result = OpenAI::completions()->create([
            'max_tokens' => 50,
            'model' => 'gpt-3.5-turbo',
            'prompt' => $request->input,
            'options' => [
                'verify' => false, // Disable SSL verification (Development only)
            ],
        ]);

        $response = array_reduce(
            $result->toArray()['choices'],
            fn(string $result, array $choice) => $result . $choice['text'], ""
        );

        dd($response);
    }
}
