@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un nouvel incident</h1>
    <form action="{{ route('incidents.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select name="status" id="status" class="form-select" required>
                <option value="critique">Critique</option>
                <option value="en_cours">En cours</option>
                <option value="resolu">Résolu</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="server_id" class="form-label">Serveur concerné</label>
            <select name="server_id" id="server_id" class="form-select" required>
                @foreach($servers as $server)
                    <option value="{{ $server->id }}">{{ $server->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Assigné à</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
