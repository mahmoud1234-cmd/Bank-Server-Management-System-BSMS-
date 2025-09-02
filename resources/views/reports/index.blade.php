@extends('layouts.app') {{-- Layout principal --}}

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Analyse des Serveurs</h1>

    <div class="row">
        <!-- Tableau Serveurs -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title">État des Serveurs</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du Serveur</th>
                                <th>CPU</th>
                                <th>RAM</th>
                                <th>Stockage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servers as $index => $server)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $server->name }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" style="width: {{ $server->cpu }}%;">
                                            {{ $server->cpu }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width: {{ $server->ram }}%;">
                                            {{ $server->ram }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: {{ $server->storage }}%;">
                                            {{ $server->storage }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tableau Incidents -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title">Incidents en Cours</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incidents as $index => $incident)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $incident->description }}</td>
                                <td>
                                    @if($incident->status == 'critique')
                                        <span class="badge bg-danger">Critique</span>
                                    @elseif($incident->status == 'en_cours')
                                        <span class="badge bg-warning">En cours</span>
                                    @else
                                        <span class="badge bg-success">Résolu</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
