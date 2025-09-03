<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🔗 Gestion des Clusters de Serveurs
            </h2>
            <a href="{{ route('clusters.create') }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                ➕ Créer un Cluster
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($clusters->count() > 0)
                <div class="grid gap-6">
                    @foreach($clusters as $cluster)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                            <!-- En-tête du cluster -->
                            <div class="bg-gradient-to-r {{ $cluster->mode === 'actif_actif' ? 'from-blue-500 to-blue-600' : 'from-green-500 to-green-600' }} px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                            @if($cluster->mode === 'actif_actif')
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-white">{{ $cluster->name }}</h3>
                                            <p class="text-blue-100">
                                                {{ $cluster->mode === 'actif_actif' ? 'Actif / Actif (Load Balancing)' : 'Actif / Passif (Failover)' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 bg-white bg-opacity-20 text-white text-sm font-medium rounded-full">
                                            {{ $cluster->servers->count() }} serveurs
                                        </span>
                                        <div class="flex space-x-1">
                                            <a href="{{ route('clusters.edit', $cluster) }}" 
                                               class="p-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('clusters.destroy', $cluster) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cluster ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-red-500 bg-opacity-80 hover:bg-opacity-100 text-white rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Liste des serveurs -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($cluster->servers as $index => $server)
                                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-2">
                                                    @if($cluster->mode === 'actif_passif')
                                                        @if($index === 0)
                                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">PRIMAIRE</span>
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">STANDBY</span>
                                                        @endif
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">ACTIF</span>
                                                    @endif
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $server->status === 'Actif' ? 'bg-green-100 text-green-800' : 
                                                       ($server->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $server->status }}
                                                </span>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $server->name }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $server->ip_address }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $server->role }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Statistiques du cluster -->
                                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                                    <div class="grid grid-cols-3 gap-4 text-center">
                                        <div>
                                            <div class="text-2xl font-bold text-green-600">
                                                {{ $cluster->servers->where('status', 'Actif')->count() }}
                                            </div>
                                            <div class="text-xs text-gray-500">Actifs</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-yellow-600">
                                                {{ $cluster->servers->where('status', 'Maintenance')->count() }}
                                            </div>
                                            <div class="text-xs text-gray-500">Maintenance</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-red-600">
                                                {{ $cluster->servers->where('status', 'Hors service')->count() }}
                                            </div>
                                            <div class="text-xs text-gray-500">Hors service</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Aucun cluster configuré</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">
                            Commencez par créer votre premier cluster de serveurs pour améliorer la disponibilité et les performances.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('clusters.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Créer le premier cluster
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
