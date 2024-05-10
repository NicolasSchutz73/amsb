<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid md:grid-cols-3">
        <div> Col 1 </div>
        <div> Col 2 </div>
        <div> Col 3 </div>
    </div>
</x-app-layout>
