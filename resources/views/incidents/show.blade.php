<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🚨 Détails de l'Incident #{{ $incident->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('incidents.edit', $incident) }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                    ✏️ Modifier
                </a>
                <a href="{{ route('incidents.index') }}" 
                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-200">
                    ← Retour
                </a>
            </div>
        </div>
    

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- En-tête avec statut -->
                    <div class="mb-6 p-4 rounded-lg 
                        @if($incident->status === 'open') bg-red-50 border border-red-200
                        @elseif($incident->status === 'in_progress') bg-yellow-50 border border-yellow-200
                        @elseif($incident->status === 'resolved') bg-green-50 border border-green-200
                        @else bg-gray-50 border border-gray-200
                        @endif">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $incident->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Créé le {{ $incident->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($incident->status === 'open') bg-red-100 text-red-800
                                    @elseif($incident->status === 'in_progress') bg-yellow-100 text-yellow-800
                                    @elseif($incident->status === 'resolved') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($incident->status === 'open') 🔴 Ouvert
                                    @elseif($incident->status === 'in_progress') 🟡 En cours
                                    @elseif($incident->status === 'resolved') 🟢 Résolu
                                    @else ⚫ Fermé
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Informations principales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                    {{ $incident->description }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serveur Concerné</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $incident->server->name }} ({{ $incident->server->ip_address }})
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @switch($incident->category)
                                        @case('hardware') 🖥️ Matériel @break
                                        @case('software') 💻 Logiciel @break
                                        @case('network') 🌐 Réseau @break
                                        @case('security') 🔒 Sécurité @break
                                        @case('power') ⚡ Alimentation @break
                                        @case('environmental') 🌡️ Environnemental @break
                                        @default 🔧 Autre
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sévérité</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium
                                    @if($incident->severity === 'low') bg-green-100 text-green-800
                                    @elseif($incident->severity === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($incident->severity === 'high') bg-orange-100 text-orange-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($incident->severity === 'low') 🟢 Faible
                                    @elseif($incident->severity === 'medium') 🟡 Moyenne
                                    @elseif($incident->severity === 'high') 🟠 Élevée
                                    @else 🔴 Critique
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priorité</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium
                                    @if($incident->priority === 'low') bg-blue-100 text-blue-800
                                    @elseif($incident->priority === 'medium') bg-indigo-100 text-indigo-800
                                    @elseif($incident->priority === 'high') bg-purple-100 text-purple-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($incident->priority === 'low') ⬇️ Faible
                                    @elseif($incident->priority === 'medium') ➡️ Moyenne
                                    @elseif($incident->priority === 'high') ⬆️ Élevée
                                    @else 🚨 Urgente
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rapporté par</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $incident->reportedBy->name }}
                                </p>
                            </div>

                            @if($incident->assignedUser)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigné à</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $incident->assignedUser->name }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Dates importantes -->
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Chronologie</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($incident->detected_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Détecté le</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $incident->detected_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            @endif

                            @if($incident->resolved_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Résolu le</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $incident->resolved_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            @endif

                            @if($incident->getDuration())
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durée</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ number_format($incident->getDuration(), 1) }} heures
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($incident->resolution_notes)
                    <!-- Notes de résolution -->
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notes de Résolution</h4>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $incident->resolution_notes }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>
