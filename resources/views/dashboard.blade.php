<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(isset($error))
        <p>{{ $error }}</p>
    @else
        @foreach($instagram as $post)
            <img src="{{ $post->url }}" alt="Instagram Post">
            <p>{{ $post->caption ?? 'No caption' }}</p>
        @endforeach
    @endif


</x-app-layout>
