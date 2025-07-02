<?php
namespace App\Http\Controllers;

use App\Models\IaQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Utilisateur;
use App\Models\Invitation;
use Illuminate\Validation\ValidationException;

class IaController extends Controller
{
    public function form()
    {
        return view('ia.form');
    }

    public function handle(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
        ]);

        $userPrompt = $request->input('prompt');
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            abort(500, 'La clé API Gemini n\'est pas configurée dans le fichier .env.');
        }

        $fullPrompt = "Vous êtes un expert en IT. Vous devez répondre à la question suivante : {$userPrompt}. Répondez sans introduction ni conclusion.";

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl, [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $fullPrompt
                        ]
                    ]
                ]
            ]
        ]);

        $answer = "Désolé, une erreur est survenue lors de la communication avec l'API.";

        if ($response->successful()) {
            $generatedText = data_get($response->json(), 'candidates.0.content.parts.0.text');

            if ($generatedText) {
                $answer = nl2br(e($generatedText));
            } else {
                $answer = "L'API a répondu, mais n'a pas généré de contenu. Réponse complète : <pre>" . json_encode($response->json(), JSON_PRETTY_PRINT) . "</pre>";
            }
        } elseif ($response->failed()) {
            $errorDetails = $response->json('error.message', 'Aucun détail disponible.');
            $answer = "L'API a retourné une erreur : " . e($errorDetails);
        }

        // Sauvegarder la question et la réponse
        IaQuestion::create([
            'prompt' => $userPrompt,
            'answer' => $answer,
            'user_id' => Auth::id(), // Utilise null si non connecté
        ]);

        return view('ia.result', compact('userPrompt', 'answer'));
    }

    public function history()
{
    $userId = Auth::id();
    $friendIds = Utilisateur::whereIn('id', function ($query) use ($userId) {
        $query->select('sender_id')->from('invitations')
            ->where('receiver_id', $userId)->where('accepted', 1)
            ->union(
                Invitation::select('receiver_id')->where('sender_id', $userId)->where('accepted', 1)
            );
    })->pluck('id')->toArray();

    $questionUserIds = array_merge([$userId], $friendIds);
    $questions = IaQuestion::whereIn('user_id', $questionUserIds)
        ->with('user') // Charge l'utilisateur
        ->latest()
        ->get();

    return view('ia.history', compact('questions'));
}

    
}