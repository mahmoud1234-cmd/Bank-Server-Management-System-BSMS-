@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Informations du Serveur
                    </h3>
                    <a href="{{ route('servers.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour
                    </a>
                </div>
            </div>
            
            <form action="{{ route('servers.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <!-- Informations de base -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nom du serveur <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('name') border-red-500 @enderror"
                               placeholder="ex: SRV-WEB-01">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Adresse IP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="ip_address" id="ip_address" value="{{ old('ip_address') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('ip_address') border-red-500 @enderror"
                               placeholder="ex: 192.168.1.100">
                        @error('ip_address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="operating_system" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Système d'exploitation <span class="text-red-500">*</span>
                        </label>
                        <select name="operating_system" id="operating_system" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('operating_system') border-red-500 @enderror">
                            <option value="">Sélectionner un OS</option>
                            <option value="Windows Server" {{ old('operating_system') === 'Windows Server' ? 'selected' : '' }}>Windows Server</option>
                            <option value="Linux Ubuntu" {{ old('operating_system') === 'Linux Ubuntu' ? 'selected' : '' }}>Linux Ubuntu</option>
                            <option value="Linux CentOS" {{ old('operating_system') === 'Linux CentOS' ? 'selected' : '' }}>Linux CentOS</option>
                            <option value="Unix" {{ old('operating_system') === 'Unix' ? 'selected' : '' }}>Unix</option>
                        </select>
                        @error('operating_system')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Rôle <span class="text-red-500">*</span>
                        </label>
                        <select name="role" id="role" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('role') border-red-500 @enderror">
                            <option value="">Sélectionner un rôle</option>
                            <option value="Base de données" {{ old('role') === 'Base de données' ? 'selected' : '' }}>Base de données</option>
                            <option value="Application" {{ old('role') === 'Application' ? 'selected' : '' }}>Application</option>
                            <option value="Sécurité" {{ old('role') === 'Sécurité' ? 'selected' : '' }}>Sécurité</option>
                            <option value="Backup" {{ old('role') === 'Backup' ? 'selected' : '' }}>Backup</option>
                            <option value="Web" {{ old('role') === 'Web' ? 'selected' : '' }}>Web</option>
                            <option value="Mail" {{ old('role') === 'Mail' ? 'selected' : '' }}>Mail</option>
                            <option value="DNS" {{ old('role') === 'DNS' ? 'selected' : '' }}>DNS</option>
                            <option value="Monitoring" {{ old('role') === 'Monitoring' ? 'selected' : '' }}>Monitoring</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Localisation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('location') border-red-500 @enderror"
                               placeholder="ex: Datacenter Principal">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="owner" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Propriétaire/Responsable <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="owner" id="owner" value="{{ old('owner') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('owner') border-red-500 @enderror"
                               placeholder="ex: Équipe IT">
                        @error('owner')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mot de passe de connexion <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('password') border-red-500 @enderror"
                               placeholder="Mot de passe pour la connexion au serveur">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Spécifications matérielles -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                        Spécifications Matérielles
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="cpu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                CPU (Cœurs)
                            </label>
                            <input type="number" name="cpu" id="cpu" value="{{ old('cpu') }}" min="1" max="128"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('cpu') border-red-500 @enderror"
                                   placeholder="ex: 4">
                            @error('cpu')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                RAM (GB) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="ram" id="ram" value="{{ old('ram') }}" min="1" max="1024" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('ram') border-red-500 @enderror"
                                   placeholder="ex: 16">
                            @error('ram')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="storage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Stockage (GB) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="storage" id="storage" value="{{ old('storage') }}" min="1" max="10240" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('storage') border-red-500 @enderror"
                                   placeholder="ex: 500">
                            @error('storage')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Configuration avancée -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Configuration Avancée
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Statut <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('status') border-red-500 @enderror">
                                <option value="">Sélectionner un statut</option>
                                <option value="Actif" {{ old('status') === 'Actif' ? 'selected' : '' }}>Actif</option>
                                <option value="Maintenance" {{ old('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Hors service" {{ old('status') === 'Hors service' ? 'selected' : '' }}>Hors service</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="critical_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Niveau de criticité <span class="text-red-500">*</span>
                            </label>
                            <select name="critical_level" id="critical_level" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('critical_level') border-red-500 @enderror">
                                <option value="">Sélectionner un niveau</option>
                                <option value="low" {{ old('critical_level') === 'low' ? 'selected' : '' }}>Faible</option>
                                <option value="medium" {{ old('critical_level') === 'medium' ? 'selected' : '' }}>Moyen</option>
                                <option value="high" {{ old('critical_level') === 'high' ? 'selected' : '' }}>Élevé</option>
                                <option value="critical" {{ old('critical_level') === 'critical' ? 'selected' : '' }}>Critique</option>
                            </select>
                            @error('critical_level')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="environment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Environnement <span class="text-red-500">*</span>
                            </label>
                            <select name="environment" id="environment" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('environment') border-red-500 @enderror">
                                <option value="">Sélectionner un environnement</option>
                                <option value="production" {{ old('environment') === 'production' ? 'selected' : '' }}>Production</option>
                                <option value="staging" {{ old('environment') === 'staging' ? 'selected' : '' }}>Staging</option>
                                <option value="development" {{ old('environment') === 'development' ? 'selected' : '' }}>Développement</option>
                                <option value="testing" {{ old('environment') === 'testing' ? 'selected' : '' }}>Test</option>
                            </select>
                            @error('environment')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="datacenter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Datacenter
                        </label>
                        <select name="datacenter_id" id="datacenter_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('datacenter_id') border-red-500 @enderror">
                            <option value="">Sélectionner un datacenter</option>
                            @foreach($datacenters as $datacenter)
                                <option value="{{ $datacenter->id }}" {{ old('datacenter_id') == $datacenter->id ? 'selected' : '' }}>
                                    {{ $datacenter->name }} ({{ $datacenter->city }})
                                </option>
                            @endforeach
                        </select>
                        @error('datacenter_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Utilisateurs assignés -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Utilisateurs Assignés
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($users as $user)
                            <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" name="assigned_users[]" value="{{ $user->id }}" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ in_array($user->id, old('assigned_users', [])) ? 'checked' : '' }}>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->role }} - {{ $user->department }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Notes -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 @error('notes') border-red-500 @enderror"
                              placeholder="Informations supplémentaires sur le serveur...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('servers.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Créer le Serveur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
