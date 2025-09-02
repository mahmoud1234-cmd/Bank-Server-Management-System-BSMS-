@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des Clusters</h2>
    <a href="{{ route('clusters.create') }}" class="btn btn-primary mb-3">Créer un Cluster</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Mode</th>
                <th>Serveurs</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clusters as $cluster)
            <tr>
                <td>{{ $cluster->name }}</td>
                <td>{{ $cluster->mode }}</td>
                <td>
                    <ul>
                        @foreach($cluster->servers as $server)
                        <li>{{ $server->ip_address }} - {{ $server->status }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
