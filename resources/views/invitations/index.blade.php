@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Mes Amis et Invitations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h3>Mes Amis</h3>
    @if($friends->isEmpty())
        <p class="text-muted">Aucun ami pour le moment.</p>
    @else
        <ul class="list-group mb-4">
            @foreach($friends as $friend)
                <li class="list-group-item">{{ $friend->nom }} ({{ $friend->login }})</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('invitations.create') }}" class="btn btn-success mb-3">Ajouter un ami</a>

    <h3>Invitations Reçues</h3>
    @if($receivedInvitations->isEmpty())
        <p class="text-muted">Aucune invitation en attente.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Expéditeur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receivedInvitations as $invitation)
                    <tr>
                        <td>{{ $invitation->sender->nom }} ({{ $invitation->sender->login }})</td>
                        <td>
                            <form action="{{ route('invitations.accept', $invitation->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Accepter</button>
                            </form>
                            <form action="{{ route('invitations.reject', $invitation->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection