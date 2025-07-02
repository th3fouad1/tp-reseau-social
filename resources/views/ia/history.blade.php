@extends('layouts.app')
@section('title', 'Historique des recherches')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title h4 mb-4 border-bottom pb-4">Historique des recherches</h1>

            @forelse ($questions as $question)
                <div class="mb-4 p-3 border rounded bg-light">
                    <h2 class="h6 font-weight-bold mb-2">
                        Recherche par {{ $question->user->nom ?? 'Utilisateur inconnu' }} :
                        <span class="text-muted">{{ $question->prompt }}</span>
                    </h2>
                    <p>{!! $question->answer !!}</p>
                    <small class="text-muted">Posée le {{ $question->created_at->format('d/m/Y H:i') }}</small>
                </div>
            @empty
                <p class="text-muted text-center">Aucune recherche trouvée.</p>
            @endforelse

            <div class="text-end">
                <a href="{{ route('ia.form') }}" class="btn btn-outline-primary">Poser une nouvelle question</a>
            </div>
        </div>
    </div>
</div>
@endsection