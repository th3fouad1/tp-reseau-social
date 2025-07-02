@extends('layouts.app')

@section('title', 'Réponse de l\'assistant')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title h4 mb-4 border-bottom pb-4">Résultat de l'assistant</h1>

                <!-- Section de la question -->
                <div class="mb-4">
                    <h2 class="h5 font-weight-bold mb-3">Votre question :</h2>
                    <div class="p-4 bg-light border rounded">
                        <p class="text-muted fst-italic">{{ $userPrompt }}</p>
                    </div>
                </div>

                <!-- Section de la réponse -->
                <div>
                    <h2 class="h5 font-weight-bold mb-3">Réponse de l'assistant :</h2>
                    <div class="p-4 bg-primary bg-opacity-10 border border-primary rounded">
                        <p id="response-text">{!! $answer !!}</p>
                        <button type="button" id="speak-response" class="btn btn-outline-secondary mt-2">
                            <i class="bi bi-volume-up-fill me-2"></i>Lire la réponse
                        </button>
                    </div>
                </div>

                <!-- Bouton de retour -->
                <div class="mt-4 text-end">
                    <a href="{{ route('ia.form') }}" class="btn btn-outline-primary">
                        Poser une autre question
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const speakBtn = document.getElementById('speak-response');
            const responseText = document.getElementById('response-text').innerText;

            if ('speechSynthesis' in window) {
                speakBtn.addEventListener('click', () => {
                    const utterance = new SpeechSynthesisUtterance(responseText);
                    utterance.lang = 'fr-FR';
                    utterance.rate = 1;
                    window.speechSynthesis.speak(utterance);
                });
            } else {
                speakBtn.disabled = true;
                speakBtn.innerHTML = '<i class="bi bi-volume-mute-fill me-2"></i>Non supporté';
            }
        </script>
    @endpush
@endsection