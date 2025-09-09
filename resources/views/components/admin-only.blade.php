@props(['message' => 'Cette action est réservée aux administrateurs'])

@if(auth()->user() && auth()->user()->role === 'admin')
    {{ $slot }}
@else
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
        <div class="flex items-center justify-center">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <span class="text-yellow-800 font-medium">{{ $message }}</span>
        </div>
    </div>
@endif
