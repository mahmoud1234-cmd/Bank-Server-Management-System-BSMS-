<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🏢 Datacenter {{ $datacenter->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('datacenters.edit', $datacenter) }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                    ✏️ Modifier
                </a>
                <a href="{{ route('datacenters.index') }}" 
                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-200">
                    ← Retour
                </a>
            </div>
        </div>
    

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- En-tête avec statut -->
            <div class="mb-6 p-4 rounded-lg 
                @if($datacenter->status === 'operational') bg-green-50 border border-green-200
                @elseif($datacenter->status === 'maintenance') bg-yellow-50 border border-yellow-200
                @else bg-red-50 border border-red-200
                @endif">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $datacenter->name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Code: {{ $datacenter->code }} • Créé le {{ $datacenter->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($datacenter->status === 'operational') bg-green-100 text-green-800
                            @elseif($datacenter->status === 'maintenance') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            @if($datacenter->status === 'operational') 🟢 Opérationnel
                            @elseif($datacenter->status === 'maintenance') 🟡 Maintenance
                            @else 🔴 Hors ligne
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informations principales -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informations de base -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">📋 Informations Générales</h4>
                            
                            @if($datacenter->description)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    {{ $datacenter->description }}
                                </p>
                            </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacité</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $datacenter->capacity }} serveurs
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Utilisation</label>
                                    <div class="mt-1 flex items-center">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $datacenter->getUtilizationPercentage() }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $datacenter->getUtilizationPercentage() }}%</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Niveau de Sécurité</label>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium
                                        @if($datacenter->security_level === 'low') bg-green-100 text-green-800
                                        @elseif($datacenter->security_level === 'medium') bg-yellow-100 text-yellow-800
                                        @elseif($datacenter->security_level === 'high') bg-orange-100 text-orange-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        @if($datacenter->security_level === 'low') 🟢 Faible
                                        @elseif($datacenter->security_level === 'medium') 🟡 Moyen
                                        @elseif($datacenter->security_level === 'high') 🟠 Élevé
                                        @else 🔴 Critique
                                        @endif
                                    </span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fuseau Horaire</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $datacenter->timezone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Localisation -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">📍 Localisation</h4>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adresse</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $datacenter->address }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ville</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $datacenter->city }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pays</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $datacenter->country }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact et gestion -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">👤 Contact et Gestion</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($datacenter->manager)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Responsable</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        {{ $datacenter->manager }}
                                    </p>
                                </div>
                                @endif

                                @if($datacenter->contact_phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Téléphone</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a href="tel:{{ $datacenter->contact_phone }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $datacenter->contact_phone }}
                                        </a>
                                    </p>
                                </div>
                                @endif

                                @if($datacenter->contact_email)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a href="mailto:{{ $datacenter->contact_email }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $datacenter->contact_email }}
                                        </a>
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques des serveurs -->
                <div class="space-y-6">
                    <!-- Résumé des serveurs -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">📊 Serveurs</h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Total</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $datacenter->servers->count() }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">🟢 Actifs</span>
                                    <span class="text-sm font-medium text-green-600">{{ $datacenter->getActiveServersCount() }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">🟡 Maintenance</span>
                                    <span class="text-sm font-medium text-yellow-600">{{ $datacenter->getMaintenanceServersCount() }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">🔴 Hors service</span>
                                    <span class="text-sm font-medium text-red-600">{{ $datacenter->getDownServersCount() }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">⚠️ Critiques</span>
                                    <span class="text-sm font-medium text-red-600">{{ $datacenter->getCriticalServersCount() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">⚡ Actions Rapides</h4>
                            
                            <div class="space-y-2">
                                <a href="{{ route('servers.create') }}?datacenter_id={{ $datacenter->id }}" 
                                   class="w-full flex items-center px-3 py-2 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Ajouter un serveur
                                </a>

                                <a href="{{ route('servers.index') }}?datacenter={{ $datacenter->id }}" 
                                   class="w-full flex items-center px-3 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Voir tous les serveurs
                                </a>

                                <a href="{{ route('incidents.create') }}?datacenter_id={{ $datacenter->id }}" 
                                   class="w-full flex items-center px-3 py-2 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Signaler un incident
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>
