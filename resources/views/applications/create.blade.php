@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                    <i class="fas fa-plus-circle mr-2"></i>Nouvelle Application
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Remplissez le formulaire ci-dessous pour ajouter une nouvelle application au système.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Veuillez corriger les erreurs suivantes :
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('applications.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations générales -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <i class="fas fa-info-circle mr-2"></i>Informations générales
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="application" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Application <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="application" id="application" value="{{ old('application') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="sous_application_module" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Sous-application / Module
                                        </label>
        
                                        <input type="text" name="sous_application_module" id="sous_application_module" value="{{ old('sous_application_module') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="editeur" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Éditeur
                                        </label>
                                        <input type="text" name="editeur" id="editeur" value="{{ old('editeur') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                </div>

                                <div>
                                    <label for="descriptif" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Descriptif
                                    </label>
                                    <textarea name="descriptif" id="descriptif" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('descriptif') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration: supprimée pour le schéma minimal -->
                    </div>

                    <div class="space-y-6">
                        <!-- Responsables -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <i class="fas fa-users mr-2"></i>Responsables
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="direction" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Direction
                                    </label>
                                    <input type="text" name="direction" id="direction" value="{{ old('direction') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>

                                <div>
                                    <label for="resp_applicatif" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Responsable Applicatif <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="resp_applicatif" id="resp_applicatif" value="{{ old('resp_applicatif') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                </div>

                                <div>
                                    <label for="resp_metier" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Responsable Métier <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="resp_metier" id="resp_metier" value="{{ old('resp_metier') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                </div>

                                
                            </div>
                        </div>

                        <!-- Infrastructure -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                                <i class="fas fa-server mr-2"></i>Infrastructure
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="server_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Serveur
                                    </label>
                                    <select name="server_id" id="server_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="">Sélectionner un serveur</option>
                                        @foreach($servers as $server)
                                            <option value="{{ $server->id }}" {{ old('server_id') == $server->id ? 'selected' : '' }}>
                                                {{ $server->name }} ({{ $server->ip_address }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                

                                
                            </div>
                        </div>

                        

                        
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end space-x-3">
                    <a href="{{ route('applications.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i>Enregistrer l'application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialisation des tooltips avec Tippy.js si disponible
    document.addEventListener('DOMContentLoaded', function() {
        // Vérification de la validité des dates
        const lastUpdated = document.getElementById('last_updated');
        const nextUpdate = document.getElementById('next_update');
        
        if (lastUpdated && nextUpdate) {
            lastUpdated.addEventListener('change', function() {
                nextUpdate.min = this.value;
            });
        }
    });
</script>
@endpush
@endsection
