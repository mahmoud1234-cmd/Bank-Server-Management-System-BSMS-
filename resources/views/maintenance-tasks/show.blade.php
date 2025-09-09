<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🔧 Détails de la Tâche #{{ $maintenanceTask->id }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('maintenance-tasks.edit', $maintenanceTask) }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                    ✏️ Modifier
                </a>
                <a href="{{ route('maintenance-tasks.index') }}" 
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
                        @if($maintenanceTask->status === 'pending') bg-blue-50 border border-blue-200
                        @elseif($maintenanceTask->status === 'in_progress') bg-yellow-50 border border-yellow-200
                        @elseif($maintenanceTask->status === 'completed') bg-green-50 border border-green-200
                        @else bg-red-50 border border-red-200
                        @endif">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Créée le {{ $maintenanceTask->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($maintenanceTask->status === 'pending') bg-blue-100 text-blue-800
                                    @elseif($maintenanceTask->status === 'in_progress') bg-yellow-100 text-yellow-800
                                    @elseif($maintenanceTask->status === 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($maintenanceTask->status === 'pending') 📅 En attente
                                    @elseif($maintenanceTask->status === 'in_progress') 🔄 En cours
                                    @elseif($maintenanceTask->status === 'completed') ✅ Terminée
                                    @else ❌ Annulée
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
                                    {{ $maintenanceTask->description }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Serveur Concerné</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->server->name }} ({{ $maintenanceTask->server->ip_address }})
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type de Maintenance</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @switch($maintenanceTask->type)
                                        @case('preventive') 🔧 Préventive @break
                                        @case('corrective') 🚨 Corrective @break
                                        @case('emergency') 🚨 Urgence @break
                                        @case('upgrade') ⬆️ Mise à niveau @break
                                        @case('backup') 💾 Sauvegarde @break
                                        @case('security') 🔒 Sécurité @break
                                        @default 🔧 Autre
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priorité</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-sm font-medium
                                    @if($maintenanceTask->priority === 'low') bg-blue-100 text-blue-800
                                    @elseif($maintenanceTask->priority === 'medium') bg-indigo-100 text-indigo-800
                                    @elseif($maintenanceTask->priority === 'high') bg-purple-100 text-purple-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    @if($maintenanceTask->priority === 'low') ⬇️ Faible
                                    @elseif($maintenanceTask->priority === 'medium') ➡️ Moyenne
                                    @elseif($maintenanceTask->priority === 'high') ⬆️ Élevée
                                    @else 🚨 Urgente
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durée Estimée</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->estimated_duration }} heures
                                </p>
                            </div>

                            @if($maintenanceTask->assignedUser)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigné à</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->assignedUser->name }}
                                </p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Créé par</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->createdBy->name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Planification -->
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Planification</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Prévue</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->scheduled_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>

                            @if($maintenanceTask->started_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Démarrée le</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->started_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            @endif

                            @if($maintenanceTask->completed_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Terminée le</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $maintenanceTask->completed_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($maintenanceTask->notes)
                    <!-- Notes -->
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notes</h4>
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $maintenanceTask->notes }}
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($maintenanceTask->completion_notes)
                    <!-- Notes de completion -->
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notes de Completion</h4>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $maintenanceTask->completion_notes }}
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
