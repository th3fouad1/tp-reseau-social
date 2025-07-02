@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">👤 Mon Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('utilisateurs.profile.update') }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $utilisateur->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="login" class="form-label">Email</label>
            <input type="email" name="login" id="login" class="form-control" value="{{ $utilisateur->login }}" required>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Enregistrer
            </button>
        </div>
    </form>

    <form action="{{ route('utilisateurs.profile.destroy') }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')">
            <i class="bi bi-trash"></i> Supprimer mon compte
        </button>
    </form>
</div>
@endsection