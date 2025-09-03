<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ✏️ Modifier la Tâche #{{ $maintenanceTask->id }}
        </h2>
    

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('maintenance-tasks.update', $maintenanceTask) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Titre de la tâche -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Titre de la Tâche
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $maintenanceTask->title) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                   placeholder="Titre de la maintenance..."
                                   required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                      placeholder="Description détaillée de la maintenance..."
                                      required>{{ old('description', $maintenanceTask->description) }}</textarea>
                        </div>

                        <!-- Type de maintenance -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type de Maintenance
                            </label>
                            <select name="type" 
                                    id="type" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner un type --</option>
                                <option value="preventive" {{ old('type', $maintenanceTask->type) == 'preventive' ? 'selected' : '' }}>🔧 Préventive</option>
                                <option value="corrective" {{ old('type', $maintenanceTask->type) == 'corrective' ? 'selected' : '' }}>🚨 Corrective</option>
                                <option value="emergency" {{ old('type', $maintenanceTask->type) == 'emergency' ? 'selected' : '' }}>🚨 Urgence</option>
                                <option value="upgrade" {{ old('type', $maintenanceTask->type) == 'upgrade' ? 'selected' : '' }}>⬆️ Mise à niveau</option>
                                <option value="backup" {{ old('type', $maintenanceTask->type) == 'backup' ? 'selected' : '' }}>💾 Sauvegarde</option>
                                <option value="security" {{ old('type', $maintenanceTask->type) == 'security' ? 'selected' : '' }}>🔒 Sécurité</option>
                            </select>
                        </div>

                        <!-- Priorité -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Priorité
                            </label>
                            <select name="priority" 
                                    id="priority" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner la priorité --</option>
                                <option value="low" {{ old('priority', $maintenanceTask->priority) == 'low' ? 'selected' : '' }}>⬇️ Faible</option>
                                <option value="medium" {{ old('priority', $maintenanceTask->priority) == 'medium' ? 'selected' : '' }}>➡️ Moyenne</option>
                                <option value="high" {{ old('priority', $maintenanceTask->priority) == 'high' ? 'selected' : '' }}>⬆️ Élevée</option>
                                <option value="urgent" {{ old('priority', $maintenanceTask->priority) == 'urgent' ? 'selected' : '' }}>🚨 Urgente</option>
                            </select>
                        </div>

                        <!-- Serveur concerné -->
                        <div>
                            <label for="server_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Serveur Concerné
                            </label>
                            <select name="server_id" 
                                    id="server_id" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner un serveur --</option>
                                @if(isset($servers))
                                    @foreach($servers as $server)
                                        <option value="{{ $server->id }}" {{ old('server_id', $maintenanceTask->server_id) == $server->id ? 'selected' : '' }}>
                                            {{ $server->name }} ({{ $server->ip_address }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Date prévue -->
                        <div>
                            <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date Prévue
                            </label>
                            <input type="datetime-local" 
                                   name="scheduled_at" 
                                   id="scheduled_at" 
                                   value="{{ old('scheduled_at', $maintenanceTask->scheduled_at ? $maintenanceTask->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                   required>
                        </div>

                        <!-- Durée estimée -->
                        <div>
                            <label for="estimated_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Durée Estimée (en heures)
                            </label>
                            <input type="number" 
                                   name="estimated_duration" 
                                   id="estimated_duration" 
                                   value="{{ old('estimated_duration', $maintenanceTask->estimated_duration) }}"
                                   min="0.5" 
                                   step="0.5"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                   placeholder="Ex: 2.5"
                                   required>
                        </div>

                        <!-- Assigné à -->
                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Assigné à
                            </label>
                            <select name="assigned_to" 
                                    id="assigned_to" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">-- Assigner à un utilisateur (optionnel) --</option>
                                @if(isset($users))
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to', $maintenanceTask->assigned_to) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->role ?? 'Utilisateur' }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Statut
                            </label>
                            <select name="status" 
                                    id="status" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner un statut --</option>
                                <option value="pending" {{ old('status', $maintenanceTask->status) == 'pending' ? 'selected' : '' }}>
                                    📅 En attente
                                </option>
                                <option value="in_progress" {{ old('status', $maintenanceTask->status) == 'in_progress' ? 'selected' : '' }}>
                                    🔄 En cours
                                </option>
                                <option value="completed" {{ old('status', $maintenanceTask->status) == 'completed' ? 'selected' : '' }}>
                                    ✅ Terminée
                                </option>
                                <option value="cancelled" {{ old('status', $maintenanceTask->status) == 'cancelled' ? 'selected' : '' }}>
                                    ❌ Annulée
                                </option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Notes
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                      placeholder="Notes additionnelles...">{{ old('notes', $maintenanceTask->notes) }}</textarea>
                        </div>

                        <!-- Notes de completion -->
                        <div>
                            <label for="completion_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Notes de Completion
                            </label>
                            <textarea name="completion_notes" 
                                      id="completion_notes" 
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                      placeholder="Notes sur la completion de la tâche...">{{ old('completion_notes', $maintenanceTask->completion_notes) }}</textarea>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('maintenance-tasks.show', $maintenanceTask) }}" 
                               class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Mettre à Jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </x-slot>
</x-app-layout>
