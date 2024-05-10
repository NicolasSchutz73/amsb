<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

        @if(isset($error))
            <p class="text-red-500">{{ $error }}</p>
        @else
            <div class="grid grid-cols-3 gap-4"">
                @foreach($instagram as $post)
                    <div>
                        <img src="{{ $post->url }}" alt="Instagram Post" class="w-full object-cover rounded-lg">
                    </div>
                @endforeach
            </div>
        @endif


            <div class="grid grid-cols-4 gap-4">
                <div>01</div>
                <div>02</div>
                <div>03</div>
                <div>04</div>

                <!-- ... -->
                <div>09</div>
            </div>
</x-app-layout>
