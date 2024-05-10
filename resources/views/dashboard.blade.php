<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap -mx-2">
        <div class="p-2 w-1/3">
            <img src="https://source.unsplash.com/random/300x300?sig=1" alt="Photo 1" class="w-full h-auto">
        </div>
        <div class="p-2 w-1/3">
            <img src="https://source.unsplash.com/random/300x300?sig=2" alt="Photo 2" class="w-full h-auto">
        </div>
        <div class="p-2 w-1/3">
            <img src="https://source.unsplash.com/random/300x300?sig=3" alt="Photo 3" class="w-full h-auto">
        </div>
        <div class="p-2 w-1/3">
            <img src="https://source.unsplash.com/random/300x300?sig=4" alt="Photo 4" class="w-full h-auto">
        </div>
        <div class="p-2 w-1/3">
            <img src="https://source.unsplash.com/random/300x300?sig=5" alt="Photo 5" class="w-full h-auto">
        </div>
        <div class="p-2 w-1/3">
            <img src="https://source.unsplash.com/random/300x300?sig=6" alt="Photo 6" class="w-full h-auto">
        </div>
    </div>
</x-app-layout>
