<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-2">
                @foreach($instagram as $post)
                    <div class="w-1/3 px-2 mb-4">
                        <div class="bg-gray-200 overflow-hidden" style="height: 350px;">
                            <img src="{{ $post->url }}" alt="Instagram Post" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
