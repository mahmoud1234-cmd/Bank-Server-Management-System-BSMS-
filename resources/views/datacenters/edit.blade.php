<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ✏️ Modifier le Datacenter {{ $datacenter->name }}
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

                    <form action="{{ route('datacenters.update', $datacenter) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informations de base -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">📋 Informations de Base</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nom du datacenter -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nom du Datacenter
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', $datacenter->name) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="Ex: Datacenter Paris Nord"
                                           required>
                                </div>

                                <!-- Code du datacenter -->
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Code Unique
                                    </label>
                                    <input type="text" 
                                           name="code" 
                                           id="code" 
                                           value="{{ old('code', $datacenter->code) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="Ex: DC-PAR-01"
                                           required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <textarea name="description" 
                                          id="description" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                          placeholder="Description du datacenter...">{{ old('description', $datacenter->description) }}</textarea>
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">📍 Localisation</h3>
                            
                            <!-- Adresse -->
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Adresse Complète
                                </label>
                                <textarea name="address" 
                                          id="address" 
                                          rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                          placeholder="Adresse complète du datacenter..."
                                          required>{{ old('address', $datacenter->address) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Ville -->
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Ville
                                    </label>
                                    <input type="text" 
                                           name="city" 
                                           id="city" 
                                           value="{{ old('city', $datacenter->city) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="Ex: Paris"
                                           required>
                                </div>

                                <!-- Pays -->
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Pays
                                    </label>
                                    <input type="text" 
                                           name="country" 
                                           id="country" 
                                           value="{{ old('country', $datacenter->country) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="Ex: France"
                                           required>
                                </div>

                                <!-- Timezone -->
                                <div>
                                    <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Fuseau Horaire
                                    </label>
                                    <select name="timezone" 
                                            id="timezone" 
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                        <option value="UTC" {{ old('timezone', $datacenter->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                        <option value="Europe/Paris" {{ old('timezone', $datacenter->timezone) == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                                        <option value="America/New_York" {{ old('timezone', $datacenter->timezone) == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                        <option value="Asia/Tokyo" {{ old('timezone', $datacenter->timezone) == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration technique -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">⚙️ Configuration Technique</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Capacité -->
                                <div>
                                    <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Capacité (nombre de serveurs)
                                    </label>
                                    <input type="number" 
                                           name="capacity" 
                                           id="capacity" 
                                           value="{{ old('capacity', $datacenter->capacity) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="Ex: 100"
                                           required>
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
                                        <option value="operational" {{ old('status', $datacenter->status) == 'operational' ? 'selected' : '' }}>🟢 Opérationnel</option>
                                        <option value="maintenance" {{ old('status', $datacenter->status) == 'maintenance' ? 'selected' : '' }}>🟡 Maintenance</option>
                                        <option value="offline" {{ old('status', $datacenter->status) == 'offline' ? 'selected' : '' }}>🔴 Hors ligne</option>
                                    </select>
                                </div>

                                <!-- Niveau de sécurité -->
                                <div>
                                    <label for="security_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Niveau de Sécurité
                                    </label>
                                    <select name="security_level" 
                                            id="security_level" 
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                            required>
                                        <option value="low" {{ old('security_level', $datacenter->security_level) == 'low' ? 'selected' : '' }}>🟢 Faible</option>
                                        <option value="medium" {{ old('security_level', $datacenter->security_level) == 'medium' ? 'selected' : '' }}>🟡 Moyen</option>
                                        <option value="high" {{ old('security_level', $datacenter->security_level) == 'high' ? 'selected' : '' }}>🟠 Élevé</option>
                                        <option value="critical" {{ old('security_level', $datacenter->security_level) == 'critical' ? 'selected' : '' }}>🔴 Critique</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact et gestion -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">👤 Contact et Gestion</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Manager -->
                                <div>
                                    <label for="manager" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Responsable
                                    </label>
                                    <input type="text" 
                                           name="manager" 
                                           id="manager" 
                                           value="{{ old('manager', $datacenter->manager) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="Nom du responsable">
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Téléphone
                                    </label>
                                    <input type="tel" 
                                           name="contact_phone" 
                                           id="contact_phone" 
                                           value="{{ old('contact_phone', $datacenter->contact_phone) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="+33 1 23 45 67 89">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email
                                    </label>
                                    <input type="email" 
                                           name="contact_email" 
                                           id="contact_email" 
                                           value="{{ old('contact_email', $datacenter->contact_email) }}"
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                                           placeholder="datacenter@example.com">
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('datacenters.show', $datacenter) }}" 
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
