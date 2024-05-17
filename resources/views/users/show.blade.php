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
        @php
            $documentUrl = "https://mcida.fr/AMSB/documents/" . $user->id . ".pdf";
            $headers = get_headers($documentUrl);
        @endphp
        <div class="mb-4">
            @php
                $imageUrl = "https://mcida.fr/AMSB/profile/" . $user->id . ".jpg";
                $headers = get_headers($imageUrl);
            @endphp

            @if (strpos($headers[0], '200') !== false)
                <img src="{{ $imageUrl }}" alt="Photo de profil" class="rounded-full h-32 w-32 object-cover mx-auto">
            @else
                <img src="{{ asset('anonyme.jpeg') }}" alt="Photo par défaut" class="rounded-full h-32 w-32 object-cover mx-auto">
            @endif
            <h2 style="width: 100%; text-align: center" class="mt-2 font-bold">{{ $user->firstname }} {{ $user->lastname }}</h2>
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

        <!-- Affichage des photos -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Photos</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @if(!empty($photos))
                    @foreach($photos as $photo)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer" onclick="openModal('{{ $photo }}')">
                            <img src="{{ $photo }}" alt="Photo de l'utilisateur" class="w-full h-48 object-cover">
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600 dark:text-gray-400">Aucune photo disponible.</p>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-3xl w-full mx-5">
            <div class="flex justify-end p-2">
                <button onclick="closeModal()" class="text-gray-700 hover:text-gray-900">&times;</button>
            </div>
            <img id="modalImage" src="" alt="Photo en grand" class="w-full h-auto">
            <div class="p-4 flex justify-between items-center">
                <a id="downloadButton" href="" download class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Télécharger</a>
{{--                @canany(['Admin', 'Super Admin', 'coach'])--}}
{{--                    <button id="deleteButton" onclick="deletePhoto()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>--}}
{{--                @endcanany--}}
            </div>
        </div>
    </div>
    <script>
        let currentPhotoUrl = '';

        function openModal(photoUrl) {
            currentPhotoUrl = photoUrl;
            document.getElementById('modalImage').src = photoUrl;
            document.getElementById('downloadButton').href = photoUrl;
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        {{--function deletePhoto() {--}}
        {{--    if (confirm('Voulez-vous vraiment supprimer cette photo ?')) {--}}
        {{--        // Envoyer une requête pour supprimer la photo--}}
        {{--        fetch('{{ route('photo.delete') }}', {--}}
        {{--            method: 'DELETE',--}}
        {{--            headers: {--}}
        {{--                'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
        {{--                'Content-Type': 'application/json',--}}
        {{--            },--}}
        {{--            body: JSON.stringify({ photoUrl: currentPhotoUrl }),--}}
        {{--        })--}}
        {{--            .then(response => {--}}
        {{--                if (response.ok) {--}}
        {{--                    closeModal();--}}
        {{--                    location.reload();--}}
        {{--                } else {--}}
        {{--                    alert('Une erreur est survenue lors de la suppression de la photo.');--}}
        {{--                }--}}
        {{--            })--}}
        {{--            .catch(error => {--}}
        {{--                alert('Une erreur est survenue lors de la suppression de la photo.');--}}
        {{--            });--}}
        {{--    }--}}
        {{--}--}}
    </script>
</x-app-layout>
