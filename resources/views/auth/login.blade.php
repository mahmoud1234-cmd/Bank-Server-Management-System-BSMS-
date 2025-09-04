<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BSMS') }} - Connexion</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        /* Force refresh styles */
        .login-container {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 50%, #eff6ff 100%);
        }
        .dark .login-container {
            background: linear-gradient(135deg, #111827 0%, #1f2937 50%, #111827 100%);
        }
        
        /* Green theme for login consistency with register */
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
        
        .text-green {
            color: #16a34a !important;
        }
        .text-green:hover {
            color: #15803d !important;
        }
        
        .checkbox-green:checked {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen login-container flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 animate-fade-in">
            <!-- Logo and Header -->
            <div class="text-center">
                <img src="{{ asset('logo.png') }}" alt="BSMS Logo" class="mx-auto w-24 h-24 object-contain mb-4">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">BSMS</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-2">Bank Server Management System</p>
                <p class="text-sm text-gray-500 dark:text-gray-500">Connectez-vous à votre compte</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700 backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            Adresse email
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg input-green dark:bg-gray-700 dark:text-gray-100 transition-colors duration-200 @error('email') border-red-500 @enderror"
                               placeholder="votre@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Mot de passe
                        </label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg input-green dark:bg-gray-700 dark:text-gray-100 transition-colors duration-200 @error('password') border-red-500 @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 checkbox-green border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-green">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg shadow-sm text-sm font-medium btn-green">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Se connecter
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" class="font-medium text-green transition-colors duration-200">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-xs text-gray-500 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} BSMS - Bank Server Management System</p>
                <p>Système de gestion des serveurs bancaires</p>
            </div>
        </div>
    </div>
</body>
</html>
