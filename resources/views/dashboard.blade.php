<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container mx-auto px-4 py-4">
            <div class="test"> <!-- Assurez-vous que flex-wrap est actif ici -->
                @foreach($instagram as $post)
                    <div class="w-1/3 mb-4 px-2">
                        <div class="h-12 bg-indigo-200" style="height: 300px;">
                            <img src="{{ $post->url }}" alt="Instagram Post" class="w-full h-full object-cover">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <style>
        .test {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
    </style>
</x-app-layout>

