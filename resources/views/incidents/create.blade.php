<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🚨 Créer un Nouvel Incident
        </h2>
    </x-slot>

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

                    <form action="{{ route('incidents.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Titre de l'incident -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Titre de l'Incident
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                   placeholder="Titre court de l'incident..."
                                   required>
                        </div>

                        <!-- Description de l'incident -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description de l'Incident
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                      placeholder="Décrivez l'incident en détail..."
                                      required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catégorie
                            </label>
                            <select name="category" 
                                    id="category" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner une catégorie --</option>
                                <option value="hardware" {{ old('category') == 'hardware' ? 'selected' : '' }}>🖥️ Matériel</option>
                                <option value="software" {{ old('category') == 'software' ? 'selected' : '' }}>💻 Logiciel</option>
                                <option value="network" {{ old('category') == 'network' ? 'selected' : '' }}>🌐 Réseau</option>
                                <option value="security" {{ old('category') == 'security' ? 'selected' : '' }}>🔒 Sécurité</option>
                                <option value="performance" {{ old('category') == 'performance' ? 'selected' : '' }}>⚡ Performance</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>🔧 Autre</option>
                            </select>
                        </div>

                        <!-- Sévérité -->
                        <div>
                            <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sévérité
                            </label>
                            <select name="severity" 
                                    id="severity" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner la sévérité --</option>
                                <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>🟢 Faible</option>
                                <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>🟡 Moyenne</option>
                                <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>🟠 Élevée</option>
                                <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>🔴 Critique</option>
                            </select>
                        </div>

                        <!-- Priorité -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Priorité
                            </label>
                            <select name="priority" 
                                    id="priority" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner la priorité --</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>⬇️ Faible</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>➡️ Moyenne</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>⬆️ Élevée</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>🚨 Urgente</option>
                            </select>
                        </div>

                        <!-- Niveau d'impact -->
                        <div>
                            <label for="impact_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Niveau d'Impact
                            </label>
                            <select name="impact_level" 
                                    id="impact_level" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner l'impact --</option>
                                <option value="minimal" {{ old('impact_level') == 'minimal' ? 'selected' : '' }}>🟢 Minimal</option>
                                <option value="minor" {{ old('impact_level') == 'minor' ? 'selected' : '' }}>🟡 Mineur</option>
                                <option value="major" {{ old('impact_level') == 'major' ? 'selected' : '' }}>🟠 Majeur</option>
                                <option value="critical" {{ old('impact_level') == 'critical' ? 'selected' : '' }}>🔴 Critique</option>
                            </select>
                        </div>

                        <!-- Statut de l'incident -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Statut de l'Incident
                            </label>
                            <select name="status" 
                                    id="status" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner un statut --</option>
                                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>
                                    🔴 Ouvert
                                </option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>
                                    🟡 En cours
                                </option>
                                <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>
                                    🟢 Résolu
                                </option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>
                                    ⚫ Fermé
                                </option>
                            </select>
                        ></div>

                        <!-- Serveur concerné -->
                        <div>
                            <label for="server_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Serveur Concerné
                            </label>
                            <select name="server_id" 
                                    id="server_id" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="">-- Sélectionner un serveur --</option>
                                @foreach($servers as $server)
                                    <option value="{{ $server->id }}" {{ old('server_id') == $server->id ? 'selected' : '' }}>
                                        {{ $server->name }} ({{ $server->ip_address }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Assigné à -->
                        <div>
                            <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Assigné à
                            </label>
                            <select name="assigned_to" 
                                    id="assigned_to" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">-- Assigner à un utilisateur (optionnel) --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role ?? 'Utilisateur' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('incidents.index') }}" 
                               class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-200">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Créer l'Incident
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
