@extends('layouts.app')

@section('title', 'Interroger l\'assistant')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary text-white rounded-circle p-3 me-3">
                        <i class="bi bi-lightbulb-fill" style="font-size: 1.5rem;"></i>
                    </div>
                    <h1 class="card-title h4 mb-0">Interroger l'assistant</h1>
                </div>

                <form action="{{ route('ia.handle') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="prompt" class="form-label">Votre question :</label>
                        <textarea 
                            name="prompt" 
                            id="prompt" 
                            rows="5" 
                            class="form-control @error('prompt') is-invalid @enderror" 
                            placeholder="Votre question ici..."
                            required
                        >{{ old('prompt') }}</textarea>
                        @error('prompt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="button" id="start-speech" class="btn btn-outline-secondary">
                            <i class="bi bi-mic-fill me-2"></i>Parler
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="text-end">
                        <a href="{{ route('ia.history') }}" class="btn btn-outline-info me-2">
                            <i class="bi bi-clock-history me-2"></i>Historique
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Envoyer la question
                            <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const startSpeechBtn = document.getElementById('start-speech');
            const promptTextarea = document.getElementById('prompt');
            if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                const recognition = new SpeechRecognition();
                recognition.lang = 'fr-FR';
                recognition.interimResults = false;

                startSpeechBtn.addEventListener('click', () => {
                    recognition.start();
                    startSpeechBtn.innerHTML = '<i class="bi bi-mic-mute-fill me-2"></i>En écoute...';
                    startSpeechBtn.className = 'btn btn-outline-warning';
                });

                recognition.onresult = (event) => {
                    const transcript = event.results[0][0].transcript;
                    promptTextarea.value = transcript;
                    startSpeechBtn.innerHTML = '<i class="bi bi-mic-fill me-2"></i>Parler';
                    startSpeechBtn.className = 'btn btn-outline-secondary';
                };

                recognition.onend = () => {
                    startSpeechBtn.innerHTML = '<i class="bi bi-mic-fill me-2"></i>Parler';
                    startSpeechBtn.className = 'btn btn-outline-secondary';
                };
            } else {
                startSpeechBtn.disabled = true;
                startSpeechBtn.innerHTML = '<i class="bi bi-mic-mute-fill me-2"></i>Non supporté';
            }
        </script>
    @endpush
@endsection
