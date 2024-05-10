<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4">
        @if(isset($error))
            <p class="text-red-500">{{ $error }}</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($instagram as $post)
                    <div>
                        <img src="{{ $post->url }}" alt="Instagram Post" class="w-full object-cover rounded-lg">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
