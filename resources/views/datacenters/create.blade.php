@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Créer un Datacenter</h1>

    <form method="POST" action="{{ route('datacenters.store') }}">
        @csrf

        <!-- Exemple : Nom -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-200">Nom :</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
        </div>

        <!-- Exemple : Code -->
        <div class="mb-4">
            <label for="code" class="block text-gray-700 dark:text-gray-200">Code :</label>
            <input type="text" name="code" id="code" class="w-full p-2 border rounded" required>
        </div>

        <!-- Ajoute ici les autres champs comme adresse, ville, pays... -->

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </form>
</div>
@endsection
