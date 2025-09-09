<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🖥️ Ajouter un Serveur au Site
        </h2>
    

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            📋 Informations du Serveur
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Ajoutez rapidement un serveur au site avec ses informations de connexion essentielles.
                        </p>
                    </div>

                    <form action="{{ route('servers.store-to-site') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Nom du serveur -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="text-red-500">*</span> Nom du Serveur
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-lg" 
                                   placeholder="Ex: Server-Web-01"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Nom unique pour identifier le serveur</p>
                        </div>

                        <!-- Adresse IP -->
                        <div>
                            <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="text-red-500">*</span> Adresse IP
                            </label>
                            <input type="text" 
                                   name="ip_address" 
                                   id="ip_address" 
                                   value="{{ old('ip_address') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-lg font-mono" 
                                   placeholder="192.168.1.100"
                                   pattern="^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$"
                                   required>
                            <p class="mt-1 text-xs text-gray-500">Adresse IP du serveur (format IPv4)</p>
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="text-red-500">*</span> Mot de Passe
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-lg" 
                                       placeholder="••••••••••••"
                                       required>
                                <button type="button" 
                                        onclick="togglePassword()" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg id="eye-open" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg id="eye-closed" class="h-5 w-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Mot de passe de connexion au serveur</p>
                        </div>

                        <!-- Informations automatiques -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">
                                ℹ️ Informations automatiques
                            </h4>
                            <div class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                                <p>• <strong>Statut:</strong> Actif (par défaut)</p>
                                <p>• <strong>Environnement:</strong> Production</p>
                                <p>• <strong>Niveau critique:</strong> Medium</p>
                                <p>• <strong>Rôle:</strong> Serveur Web</p>
                                <p>• <strong>Propriétaire:</strong> {{ auth()->user()->name }}</p>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('servers.index') }}" 
                               class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Annuler
                            </a>
                            
                            <button type="submit" 
                                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition duration-200 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Ajouter au Site
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aide rapide -->
            <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">💡 Aide Rapide</h4>
                <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <p>• Utilisez un nom descriptif pour identifier facilement le serveur</p>
                    <p>• Vérifiez que l'adresse IP est accessible depuis votre réseau</p>
                    <p>• Le mot de passe sera chiffré et stocké de manière sécurisée</p>
                    <p>• Vous pourrez modifier ces informations plus tard si nécessaire</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // Validation IP en temps réel
        document.getElementById('ip_address').addEventListener('input', function(e) {
            const value = e.target.value;
            const ipPattern = /^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/;
            
            if (value && !ipPattern.test(value)) {
                e.target.style.borderColor = '#ef4444';
            } else {
                e.target.style.borderColor = '';
            }
        });
    </script>
    </x-slot>
</x-app-layout>
