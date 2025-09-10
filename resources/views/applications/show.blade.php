@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Détails de l’Application</h1>

    <div class="bg-white shadow rounded p-4 space-y-3">
        <p><strong>Nom :</strong> {{ $application->application }}</p>
        <p><strong>Sous-application / Module :</strong> {{ $application->sous_application_module }}</p>
        <p><strong>Éditeur :</strong> {{ $application->editeur }}</p>
        <p><strong>Descriptif :</strong> {{ $application->descriptif }}</p>
        <p><strong>Direction :</strong> {{ $application->direction }}</p>
        <p><strong>Responsable Applicatif :</strong> {{ $application->resp_applicatif }}</p>
        <p><strong>Responsable Métier :</strong> {{ $application->resp_metier }}</p>
        <p><strong>Serveur :</strong> {{ $application->server->name ?? 'N/A' }}</p>
    </div>

    <div class="mt-4 flex gap-2">
        <a href="{{ route('applications.edit', $application) }}" class="px-4 py-2 bg-yellow-600 text-white rounded shadow hover:bg-yellow-700">
            ✏️ Modifier
        </a>
        <a href="{{ route('applications.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded shadow hover:bg-gray-700">
            🔙 Retour
        </a>
    </div>
</div>
@endsection
