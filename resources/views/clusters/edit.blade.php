<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🔗 Modifier le Cluster: {{ $cluster->name }}
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

                    <form action="{{ route('clusters.update', $cluster) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nom du cluster -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nom du Cluster
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $cluster->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                   required>
                        </div>

                        <!-- Mode du cluster -->
                        <div>
                            <label for="mode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mode de Fonctionnement
                            </label>
                            <select id="mode" 
                                    name="mode" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                    required>
                                <option value="actif_actif" {{ old('mode', $cluster->mode) == 'actif_actif' ? 'selected' : '' }}>
                                    Actif / Actif (Load Balancing)
                                </option>
                                <option value="actif_passif" {{ old('mode', $cluster->mode) == 'actif_passif' ? 'selected' : '' }}>
                                    Actif / Passif (Failover)
                                </option>
                            </select>
                        </div>

                        <!-- Sélection des serveurs -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Serveurs du Cluster <span class="text-red-500">*</span>
                            </label>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                ⚠️ <strong>Nombre pair obligatoire</strong> - Sélectionnez un nombre pair de serveurs
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-64 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-md p-4">
                                @php
                                    $selectedServerIds = old('server_ids', $cluster->servers->pluck('id')->toArray());
                                @endphp
                                
                                @forelse($availableServers as $server)
                                    <label class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                                        <input type="checkbox" 
                                               name="server_ids[]" 
                                               value="{{ $server->id }}"
                                               {{ in_array($server->id, $selectedServerIds) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $server->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $server->ip_address }} • {{ $server->role }} • 
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $server->status === 'Actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $server->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <div class="col-span-2 text-center py-8 text-gray-500 dark:text-gray-400">
                                        <p>Aucun serveur disponible</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <span id="selected-count">{{ count($selectedServerIds) }}</span> serveur(s) sélectionné(s)
                                <span id="pair-warning" class="text-red-500 {{ count($selectedServerIds) % 2 !== 0 ? '' : 'hidden' }} ml-2">⚠️ Nombre impair sélectionné</span>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('clusters.index') }}" 
                               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:hover:bg-gray-700">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="submit-btn">
                                💾 Mettre à jour le Cluster
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="server_ids[]"]');
            const countSpan = document.getElementById('selected-count');
            const warningSpan = document.getElementById('pair-warning');
            const submitBtn = document.getElementById('submit-btn');
            
            function updateCount() {
                const selectedCount = document.querySelectorAll('input[name="server_ids[]"]:checked').length;
                countSpan.textContent = selectedCount;
                
                if (selectedCount > 0 && selectedCount % 2 !== 0) {
                    warningSpan.classList.remove('hidden');
                    submitBtn.disabled = true;
                } else {
                    warningSpan.classList.add('hidden');
                    submitBtn.disabled = selectedCount === 0;
                }
            }
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCount);
            });
            
            updateCount(); // Initial check
        });
    </script>
</x-app-layout>
