@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un Cluster</h2>
    <form action="{{ route('clusters.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nom du cluster</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mode</label>
            <select name="mode" class="form-control" required>
                <option value="actif_actif">Actif / Actif</option>
                <option value="actif_passif">Actif / Passif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Adresses IP des serveurs (séparées par des virgules)</label>
            <input type="text" name="servers[]" class="form-control" placeholder="192.168.1.1,192.168.1.2">
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
    </form>
</div>
@endsection
