<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <label for="User Information" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                Information de l'utilisateur
            </label>
            <div>
                <a href="{{ route('users.index') }}" class="bg-blue-500 text-white py-1 px-3 rounded text-sm">&larr; Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-5">
{{--        <div class="text-center p-6">--}}
{{--            @php--}}
{{--                $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";--}}
{{--                $headers = get_headers($imageUrl);--}}
{{--            @endphp--}}
            @php
                $documentUrl = "http://mcida.eu/AMSB/documents/" . $user->id . ".pdf";
                $headers = get_headers($documentUrl);
            @endphp

{{--            @if (strpos($headers[0], '200') !== false)--}}
{{--                <img src="{{ $imageUrl }}" alt="Photo de profil" class="rounded-full h-32 w-32 object-cover mx-auto">--}}
{{--            @else--}}
{{--                <img src="{{ asset('anonyme.jpeg') }}" alt="Photo par défaut" class="rounded-full h-32 w-32 object-cover mx-auto">--}}
{{--            @endif--}}

{{--            <h3 class="mt-4 text-xl font-bold">{{ $user->firstname }} {{ $user->lastname }}</h3>--}}
{{--            <p class="text-gray-500">{{ $user->email }}</p>--}}
{{--        </div>--}}
        <div class="mb-4">
            @php
                $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
                $headers = get_headers($imageUrl);
            @endphp

            @if (strpos($headers[0], '200') !== false)
                <img src="{{ $imageUrl }}" alt="Photo de profil" class="rounded-full h-32 w-32 object-cover mx-auto">
            @else
                <img src="{{ asset('anonyme.jpeg') }}" alt="Photo par défaut" class="rounded-full h-32 w-32 object-cover mx-auto">
            @endif
        </div>

        <div class="mt-4 px-6 py-4 bg-gray-100 rounded-lg">
            <div class="mb-4">
                <strong class="text-gray-700 text-sm">Profil:</strong>
                <p class="text-gray-600">{{ $user->description ?: 'Aucune description disponible' }}</p>
            </div>
            <div class="mb-4">
                <strong class="text-gray-700 text-sm">Contact d'urgence:</strong>
                <p class="text-gray-600">{{ $user->emergency ?: 'Aucun contact d\'urgence disponible' }}</p>
            </div>
        </div>

        <div class="flex justify-center mt-4" style="flex-direction: column; gap: 10px;">
            <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" style="width: 100%; text-align: center">
                Envoyer un message
            </a>
            <a href="{{ $documentUrl }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" style=" width: 100%; text-align: center">
                Télécharger le document
            </a>
        </div>
    </div>
</x-app-layout>
