@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Envoyer une invitation</h2>

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

    <form action="{{ route('invitations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="sender_id" value="{{ Auth::id() }}">

        <div class="mb-3">
            <label for="receiver_id" class="form-label">Destinataire :</label>
            <select name="receiver_id" id="receiver_id" class="form-select" required>
                <option value="">-- Choisir un utilisateur --</option>
                @foreach($nonFriends as $user)
                    <option value="{{ $user->id }}">{{ $user->nom }} ({{ $user->login }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>
@endsection