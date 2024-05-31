<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-white">
                Gérer les utilisateurs
            </h2>
        </div>
    </x-slot>

    <div class="p-6">
        @can('create-user')
            <x-create-button route="users.create" label="Ajouter un utilisateur" />
        @endcan

        <input type="text" id="searchBar" placeholder="Rechercher des utilisateurs..." class="mt-2 mb-4 w-64 px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-gray-900">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($users as $user)
                <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col justify-between leading-normal">
                    <div class="mb-2">
                        <div class="flex mb-4">
                            @php
                                $imageUrl = "https://mcida.fr/AMSB/profile/" . $user->id . ".jpg";
                                $headers = get_headers($imageUrl);
                            @endphp
                            @if (strpos($headers[0], '200') !== false)
                                <img src="{{ $imageUrl }}" alt="Avatar de {{ $user->firstname }}" class="h-10 w-10 rounded-full mr-4" style="aspect-ratio: 1; object-fit: cover">
                            @else
                                <div class="w-10 h-10 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">N/A</span>
                                </div>
                            @endif
                            <div class="text-sm">
                                <p class="text-gray-900 leading-none">{{ $user->firstname }} {{ $user->lastname }}</p>
                                <p class="text-gray-600">{{ $user->roles->first()->name ?? 'Pas de rôle' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="text-sm">
{{--                                <p class="text-gray-500">Équipe: {{ $user->team->name ?? 'Aucune' }}</p>--}}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-around">
                        <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                        @can('update-user')
                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700 ml-4">Modifier</a>
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Supprimer</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-danger text-center py-10">Aucun utilisateur disponible pour le moment.</p>
            @endforelse
        </div>
        {{ $users->links() }}
    </div>

</x-app-layout>

<script>
    document.getElementById('searchBar').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        var userCards = document.querySelectorAll('.bg-white');

        userCards.forEach(function(card) {
            if (card.textContent.toLowerCase().includes(searchValue)) {
                card.style.display = 'block'; // L'élément correspond, on l'affiche
            } else {
                card.style.display = 'none'; // L'élément ne correspond pas, on le cache
            }
        });
    });
</script>

