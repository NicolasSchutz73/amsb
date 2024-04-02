<x-app-layout>
    <x-slot name="header">
        <x-crud-header title="Gérer les équipes" subtitle="Voici la liste des équipes disponible."></x-crud-header>
    </x-slot>

    <div class="p-6">
        @can('create-teams')
            <x-create-button route="teams.create" label="Ajouter une équipe" />
        @endcan

            <input type="text" id="searchBar" placeholder="Rechercher des utilisateurs..." class="mt-2 mb-4 w-64 px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-gray-900">

        @if (!$teams->isEmpty())
                <x-dynamic-table :headers="['ID', 'Nom', 'Catégorie', 'Action']">
                    @foreach ($teams as $team)
                        <tr class="bg-white border-b hover:bg-gray-50 team-item">
                            <td class="px-6 py-4 text-sm text-neutral-600">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-neutral-600 team-name">{{ $team->name }}</td>
                            <td class="px-6 py-4 text-sm text-neutral-600 team-category">{{ $team->category }}</td>
                            <td class="px-6 py-4 text-sm text-neutral-600">
                                <x-action-links :showRoute="'teams.show'" :editRoute="'teams.edit'" :deleteRoute="'teams.destroy'" :id="$team->id"/>
                            </td>
                        </tr>
                    @endforeach
                </x-dynamic-table>
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
                // Élargit la recherche pour inclure la catégorie en plus du nom
                if (name.includes(term) || category.includes(term)) {
                    team.style.display = '';
                } else {
                    team.style.display = 'none';
                }
            });
        });
    });
</script>
