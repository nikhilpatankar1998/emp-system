<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AIController extends Controller
{

    public function asktoai()
    {
        return view('admin.asktoai');
    }

    public function sendText(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post('http://localhost:5000/ask', [
                'json' => ['text' => $request->input('text')],
                'timeout' => 10
            ]);

            $result = json_decode($response->getBody(), true);
            // \Log::info('AI Response:', $result); 

            return response()->json($result);
        } catch (\Exception $e) {
            // \Log::error('AI Error: ' . $e->getMessage()); 
            return redirect()->back()->with('response', 'Error: ' . $e->getMessage());
        }
    }
    public function sendVoice(Request $request)
    {
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');

            $response = Http::attach(
                'audio',
                file_get_contents($audio->getRealPath()),
                $audio->getClientOriginalName()
            )->post('http://localhost:5000/transcribe');

            $result = $response->json();
            return back()->with('response', $result);
        }

        return back()->with('response', ['error' => 'No audio received']);
    }
}
