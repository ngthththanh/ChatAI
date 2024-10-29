<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatAIController extends Controller
{
    public function index(Request $request)
    {
        $chats = Chat::all();
        return view('chat', compact('chats'));
    }

    public function chat(Request $request)
    {
        $prompt = $request->query('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'No prompt provided'], 400);
        }

        $apiUrl = 'https://solitary-glitter-90d0.nguyenthanhthanhgatay.workers.dev';

        try {
            $response = Http::timeout(120)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'] ?? null;

                if (!$responseText) {
                    return response()->json(['error' => 'Malformed API response'], 500);
                }

                return response()->json(['response' => $responseText]);
            } else {
                return response()->json(['error' => 'Failed to fetch response from AI service'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);

        $prompt = $request->input('prompt');
        $apiUrl = 'https://solitary-glitter-90d0.nguyenthanhthanhgatay.workers.dev';

        try {
            $response = Http::timeout(120)->get($apiUrl, ['prompt' => $prompt]);

            if ($response->successful()) {
                $aiResponse = $response->json();
                $responseText = $aiResponse[0]['response']['response'] ?? null;

                if (!$responseText) {
                    return response()->json(['error' => 'Malformed API response'], 500);
                }

                // Save chat history in the database
                $chat = Chat::create([
                    'prompt' => $prompt,
                    'response' => $responseText,
                ]);

                return response()->json(['message' => 'Chat saved successfully', 'chat' => $chat], 201);
            } else {
                return response()->json(['error' => 'Failed to fetch response from AI API'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Request failed: ' . $e->getMessage()], 500);
        }
    }

    public function destroy()
    {
        Chat::truncate(); // hoặc thực hiện xóa theo điều kiện phù hợp
        return response()->json(['message' => 'Lịch sử chat đã được xóa thành công.']);
    }

}