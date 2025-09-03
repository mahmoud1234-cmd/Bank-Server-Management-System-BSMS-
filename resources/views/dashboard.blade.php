<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                🏦 Tableau de Bord - Gestion des Serveurs Bancaires
        </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ now()->format('d/m/Y H:i') }}
                </span>
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bannière de bienvenue -->
            <div class="mb-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Bienvenue, {{ Auth::user()->name }} !</h1>
                            <p class="text-blue-100 text-lg">Surveillez et gérez vos serveurs bancaires en temps réel</p>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-24 h-24 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques générales avec design moderne -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total des serveurs -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Total Serveurs</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['total_servers'] }}</p>
                                <p class="text-sm text-green-600 mt-1">Infrastructure complète</p>
                            </div>
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Serveurs actifs -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Serveurs Actifs</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['active_servers'] }}</p>
                                <p class="text-sm text-green-600 mt-1">{{ $stats['total_servers'] > 0 ? round(($stats['active_servers'] / $stats['total_servers']) * 100, 1) : 0 }}% opérationnels</p>
                            </div>
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Serveurs en panne -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Serveurs en Panne</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['down_servers'] }}</p>
                                <p class="text-sm text-red-600 mt-1">{{ $stats['servers_down_percentage'] }}% hors service</p>
                            </div>
                            <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Serveurs en maintenance -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Serveurs en Maintenance</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['maintenance_servers'] }}</p>
                                <p class="text-sm text-yellow-600 mt-1">{{ $stats['servers_maintenance_percentage'] }}% en maintenance</p>
                            </div>
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Incidents ouverts -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-orange-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Incidents Ouverts</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['open_incidents'] }}</p>
                                <p class="text-sm text-orange-600 mt-1">{{ $stats['critical_incidents'] }} critiques</p>
                            </div>
                            <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clusters actifs -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Clusters Actifs</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['active_clusters'] }}</p>
                                <p class="text-sm text-purple-600 mt-1">{{ $stats['total_clusters'] }} clusters total</p>
                            </div>
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques et tableaux avec design amélioré -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Serveurs par système d'exploitation -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Répartition par OS
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($serversByOS as $os => $count)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $os }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-600 rounded-full h-3 mr-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-500"
                                             style="width: {{ $stats['total_servers'] > 0 ? ($count / $stats['total_servers']) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100 min-w-[2rem] text-right">{{ $count }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Serveurs par rôle -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Répartition par Rôle
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($serversByRole as $role => $count)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $role }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-32 bg-gray-200 dark:bg-gray-600 rounded-full h-3 mr-3">
                                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all duration-500"
                                             style="width: {{ $stats['total_servers'] > 0 ? ($count / $stats['total_servers']) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100 min-w-[2rem] text-right">{{ $count }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Clustering des serveurs -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Clustering des Serveurs
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">{{ $stats['total_clusters'] }}</div>
                                <div class="text-xs text-gray-500">Clusters Total</div>
                            </div>
                            <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">{{ $stats['active_clusters'] }}</div>
                                <div class="text-xs text-gray-500">Clusters Actifs</div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($clustersByMode as $mode => $count)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 {{ $mode === 'actif_actif' ? 'bg-blue-500' : 'bg-green-500' }} rounded-full mr-3"></div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">
                                        {{ $mode === 'actif_actif' ? 'Actif / Actif' : 'Actif / Passif' }}
                                    </span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $count }}</span>
                            </div>
                            @empty
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                <p class="text-sm">Aucun cluster configuré</p>
                                <a href="{{ route('clusters.create') }}" class="text-purple-600 hover:text-purple-700 text-xs underline">
                                    Créer le premier cluster
                                </a>
                            </div>
                            @endforelse
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <div class="grid grid-cols-2 gap-4 text-center text-sm">
                                <div>
                                    <div class="font-semibold text-blue-600">{{ $clusteredServers }}</div>
                                    <div class="text-xs text-gray-500">En cluster</div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-600">{{ $standaloneServers }}</div>
                                    <div class="text-xs text-gray-500">Standalone</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers incidents et maintenances -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Derniers incidents -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Derniers Incidents
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($recentIncidents as $incident)
                            <div class="border-l-4 border-orange-500 bg-orange-50 dark:bg-orange-900/20 pl-4 py-3 rounded-r-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $incident->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $incident->server->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $incident->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($incident->severity === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($incident->severity === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                        {{ ucfirst($incident->severity) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Aucun incident récent</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Tâches de maintenance -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Maintenances Planifiées
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse($recentMaintenanceTasks as $task)
                            <div class="border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 pl-4 py-3 rounded-r-lg">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $task->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $task->server->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $task->scheduled_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($task->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">Aucune maintenance planifiée</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Serveurs critiques avec design amélioré -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Serveurs Critiques
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Serveur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rôle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">État</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Incidents Actifs</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($criticalServers as $server)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $server->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">{{ $server->ip_address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $server->role }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($server->status === 'Actif') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($server->status === 'Maintenance') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                                        {{ $server->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                        {{ $server->getActiveIncidentsCount() }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">Aucun serveur critique</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Actions rapides avec design moderne -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Actions Rapides
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('servers.create') }}" class="group relative overflow-hidden bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg">Ajouter un serveur</h4>
                                    <p class="text-blue-100 text-sm">Nouveau serveur</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('incidents.create') }}" class="group relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg">Déclarer un incident</h4>
                                    <p class="text-orange-100 text-sm">Nouveau problème</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('maintenance-tasks.create') }}" class="group relative overflow-hidden bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <div class="flex items-center">
                                <div class="bg-white/20 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-lg">Planifier une maintenance</h4>
                                    <p class="text-green-100 text-sm">Tâche préventive</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('clusters.index') }}"
   class="group relative overflow-hidden bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg p-6 text-white hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
    <div class="flex items-center">
        <div class="bg-white/20 p-3 rounded-lg mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <div>
            <h4 class="font-semibold text-lg">Clustering</h4>
            <p class="text-purple-100 text-sm">Analyse et regroupement</p>
        </div>
    </div>
</a>


    @push('scripts')
    <script>
        // Actualisation automatique des alertes toutes les 30 secondes
        setInterval(function() {
            fetch('/dashboard/alerts')
                .then(response => response.json())
                .then(alerts => {
                    // Traitement des alertes
                    console.log('Alertes mises à jour:', alerts);
                });
        }, 30000);

        // Animation des cartes au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-white, .bg-gray-800');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
    @endpush
</x-app-layout>
