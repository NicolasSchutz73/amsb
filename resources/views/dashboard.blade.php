<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        @if(isset($error))
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
                <p class="text-red-500">{{ $error }}</p>
            </div>
        @else
            <div class="grid grid-cols-3 gap-4">
                @foreach($instagram as $post)
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <img src="{{ $post->url }}" alt="Instagram Post" class="w-full h-auto object-cover rounded-lg">
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
