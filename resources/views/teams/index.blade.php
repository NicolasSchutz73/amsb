<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-white">
                Gérer les équipes
            </h2>
        </div>
    </x-slot>

    <div class="p-6">
        @can('create-teams')
            <x-create-button route="teams.create" label="Ajouter une équipe" />
        @endcan

        <input type="text" id="searchBar" placeholder="Rechercher des équipes..." class="mt-2 mb-4 w-64 px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-gray-900">

        @if (!$teams->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($teams as $team)
                    <div class="bg-white rounded-lg shadow-md p-6 team-item">
                        <h2 class="text-xl font-semibold team-name">{{ $team->name }}</h2>
                        <p class="text-gray-500 team-category">{{ $team->category }}</p>
                        <div class="mt-4">
                            <a href="{{ route('teams.show', $team->id) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                            <a href="{{ route('teams.edit', $team->id) }}" class="text-yellow-500 hover:text-yellow-700 ml-4">Modifier</a>
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-danger text-center py-10">Aucune équipe disponible pour le moment.</p>
        @endif
        {{ $teams->links() }}
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchBar = document.getElementById('searchBar');

        searchBar.addEventListener('keyup', function (e) {
            const term = e.target.value.toLowerCase();
            const teams = document.querySelectorAll('.team-item');

            teams.forEach(function (team) {
                const name = team.querySelector('.team-name').textContent.toLowerCase();
                const category = team.querySelector('.team-category').textContent.toLowerCase();
                if (name.includes(term) || category.includes(term)) {
                    team.style.display = '';
                } else {
                    team.style.display = 'none';
                }
            });
        });
    });
</script>
