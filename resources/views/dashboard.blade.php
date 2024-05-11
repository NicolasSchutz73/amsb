<x-app-layout>
    <x-slot name="header">
        <x-crud-header title="{{ __('Dashboard') }}" subtitle="Découvrez l'actualité du club."></x-crud-header>
    </x-slot>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container mx-auto px-4 py-4" style="max-width: 1200px; margin: auto;">
            <div class="test" style="display: flex; justify-content: center; flex-wrap: wrap; margin: -2px;">
                @foreach($instagram as $post)
                    <div style="width: 33.3333%; padding: 2px; box-sizing: border-box;">
                        <a href="https://www.instagram.com/amsb_test/" target="_blank" style="display: block; height: 300px; background-color: #c3b1e1; overflow: hidden; position: relative;">
                            <div class="overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(76, 85, 99, 0.5); opacity: 0; transition: opacity 0.3s ease-in-out;"></div>
                            <img src="{{ $post->url }}" alt="Instagram Post" style="width: 100%; height: 100%; object-fit: cover;">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <style>
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .test {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: -2px;
        }
        a:hover .overlay {
            opacity: 1; !important; /* Rendre le fond gris transparent visible au survol */
        }
    </style>

</x-app-layout>

