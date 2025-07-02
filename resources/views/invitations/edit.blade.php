@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Modifier l'invitation</h2>

    <form action="{{ route('invitations.update', $invitation->id) }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="sender_id" class="form-label">Expéditeur</label>
            <select name="sender_id" id="sender_id" class="form-select" required>
                @foreach ($utilisateurs as $utilisateur)
                    <option value="{{ $utilisateur->id }}" {{ $invitation->sender_id == $utilisateur->id ? 'selected' : '' }}>
                        {{ $utilisateur->nom }} (ID: {{ $utilisateur->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="receiver_id" class="form-label">Destinataire</label>
            <select name="receiver_id" id="receiver_id" class="form-select" required>
                @foreach ($utilisateurs as $utilisateur)
                    <option value="{{ $utilisateur->id }}" {{ $invitation->receiver_id == $utilisateur->id ? 'selected' : '' }}>
                        {{ $utilisateur->nom }} (ID: {{ $utilisateur->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">Invitation acceptée ?</label>
            <select name="etat" id="etat" class="form-select">
                <option value="0" {{ !$invitation->accepted ? 'selected' : '' }}>Non</option>
                <option value="1" {{ $invitation->accepted ? 'selected' : '' }}>Oui</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
