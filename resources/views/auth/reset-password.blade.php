<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BSMS') }} - Réinitialisation du mot de passe</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        /* Green theme for consistency */
        .btn-green {
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-green:hover {
            background: linear-gradient(135deg, #15803d, #166534);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }
        
        .input-green:focus {
            border-color: #16a34a !important;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1) !important;
        }
            border-radius: 10px;
            border: none;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .password-strength {
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .password-strength.weak { color: #dc3545; }
        .password-strength.medium { color: #ffc107; }
        .password-strength.strong { color: #28a745; }
    </style>
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Video Background -->
    <div class="fixed inset-0 overflow-hidden z-0">
        <video autoplay muted loop id="loginVideo" class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('3621624925-preview.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>
    
    <div class="min-h-screen relative z-10 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 animate-fade-in">
            <!-- Logo and Header -->
            <div class="text-center">
                <img src="{{ asset('logo.png') }}" alt="BSMS Logo" class="mx-auto w-24 h-24 object-contain mb-4">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Nouveau mot de passe</h2>
                <p class="text-sm text-gray-500 dark:text-gray-500">Définissez votre nouveau mot de passe</p>
            </div>

            <!-- Reset Password Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700 backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 text-red-600 dark:text-red-400 text-sm rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Veuillez corriger les erreurs suivantes :</span>
                        </div>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ __('Email') }}
                        </label>
                        <input id="email" 
                               class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" 
                               type="email" 
                               name="email" 
                               value="{{ old('email', $request->email) }}" 
                               required 
                               readonly>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                            </svg>
                            {{ __('Mot de passe') }}
                        </label>
                        <input id="password" 
                               class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               placeholder="Minimum 8 caractères">
                        <div id="passwordStrength" class="mt-2 text-sm"></div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Confirmer le mot de passe') }}
                        </label>
                        <input id="password_confirmation" 
                               class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="Répétez votre mot de passe">
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Réinitialiser le mot de passe') }}
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Retour à la connexion') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Vérification de la force du mot de passe
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            // Réinitialiser l'affichage
            strengthDiv.textContent = '';
            strengthDiv.className = 'flex items-center mt-1 text-sm';
            
            // Vérifier la longueur minimale
            if (password.length === 0) {
                return;
            } else if (password.length < 8) {
                strengthDiv.innerHTML = '<span class="text-red-500">Trop court (minimum 8 caractères)</span>';
                return;
            }
            
            // Vérifier la complexité
            let strength = 0;
            let messages = [];
            
            // Vérifier la longueur
            if (password.length >= 12) strength += 2;
            else if (password.length >= 8) strength += 1;
            
            // Vérifier les caractères spéciaux
            if (/[!@#$%^&*(),.?\":{}|<>]/.test(password)) strength += 1;
            
            // Vérifier les chiffres
            if (/\d/.test(password)) strength += 1;
            
            // Vérifier les majuscules et minuscules
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
            
            // Déterminer le niveau de force
            let strengthText = '';
            let strengthClass = '';
            let icon = '';
            
            if (strength <= 2) {
                strengthText = 'Faible';
                strengthClass = 'text-red-500';
                icon = '<svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            } else if (strength <= 4) {
                strengthText = 'Moyen';
                strengthClass = 'text-yellow-500';
                icon = '<svg class="w-4 h-4 mr-1 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            } else {
                strengthText = 'Fort';
                strengthClass = 'text-green-500';
                icon = '<svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            }
            
            // Afficher la force du mot de passe
            strengthDiv.innerHTML = `${icon}<span class="${strengthClass} font-medium">${strengthText}</span> - ${getPasswordTips(strength)}`;
            
            // Fonction pour obtenir des conseils en fonction de la force
            function getPasswordTips(strength) {
                if (strength <= 2) {
                    return 'Ajoutez des majuscules, des chiffres et des caractères spéciaux pour renforcer votre mot de passe';
                } else if (strength <= 4) {
                    return 'Bon début ! Essayez d\'allonger le mot de passe ou d\'ajouter des caractères spéciaux';
                } else {
                    return 'Excellent mot de passe !';
                }
            }
        });
    </script>
</body>
</html>
