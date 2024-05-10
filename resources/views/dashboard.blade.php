<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container mx-auto px-4 py-4" style="max-width: 1200px; margin: auto;">
            <div class="test" style="display: flex; justify-content: flex-start; flex-wrap: wrap; margin: -2px;"> <!-- Centré et avec flex-wrap -->
                @foreach($instagram as $post)
                    <div style="width: 33.3333%; padding: 12px; box-sizing: border-box;"> <!-- Éléments de la grille -->
                        <div style="height: 300px; background-color: #c3b1e1; overflow: hidden;"> <!-- Conteneur de l'image -->
                            <img src="{{ $post->url }}" alt="Instagram Post" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <style>
        .container {
            width: 100%;
            max-width: 1200px; /* Définir une largeur maximale pour le conteneur */
            margin: 0 auto; /* Centrer le conteneur */
            padding: 20px;
        }
        .test {
            display: flex;
            justify-content: center; /* Centrer les éléments de la grille horizontalement */
            flex-wrap: wrap;
            margin: -2px; /* Ajustement pour les marges négatives pour le spacing uniforme */
        }
    </style>
</x-app-layout>

