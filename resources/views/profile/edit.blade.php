<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information with Photo -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="max-w-4xl mx-auto">
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Photo Section -->
                            <div class="lg:w-1/3">
                                <div class="text-center">
                                    <div class="relative inline-block">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" 
                                                 alt="Photo de profil" 
                                                 class="w-32 h-32 lg:w-48 lg:h-48 rounded-full object-cover border-4 border-green-200 dark:border-green-600 shadow-lg">
                                        @else
                                            <div class="w-32 h-32 lg:w-48 lg:h-48 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center border-4 border-green-200 dark:border-green-600 shadow-lg">
                                                <svg class="w-16 h-16 lg:w-24 lg:h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ ucfirst($user->role) }} - {{ $user->department }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Form Section -->
                            <div class="lg:w-2/3">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Update -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
