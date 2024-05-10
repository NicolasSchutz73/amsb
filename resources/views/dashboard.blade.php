<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container">
            @foreach($instagram as $post)
                <item>
                    <img src="{{ $post->url }}" alt="Instagram Post" class="w-full object-cover rounded-lg">
                </item>
            @endforeach
        </div>
    @endif

    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .item {
            width: 32%;
            padding-bottom: 32%; /* Same as width, sets height */
            margin-bottom: 2%; /* (100-32*3)/2 */
            position: relative;
        }
    </style>
</x-app-layout>
