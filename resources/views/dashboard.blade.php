<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("Test!") }}

                </div>




            </div>
        </div>
    </div>

    @if(isset($instagram))
        @foreach($instagram as $post)
            <img src="{{ $post['url'] }}" alt="Instagram Post">
            <p>{{ $post['caption'] ?? 'No caption' }}</p>
        @endforeach
    @else
        <p>No Instagram posts to display or Instagram profile not configured.</p>
    @endif


</x-app-layout>
