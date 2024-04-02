<x-app-layout>
    <x-slot name="header">
        <!-- Utilisation du composant CRUD Header -->
        <x-crud-header title="Gérer les rôles" subtitle="Voici la liste des rôles disponible."></x-crud-header>
    </x-slot>

    <div class="p-6">
        @can('create-role')
            <!-- Utilisation du composant Create Button -->
            <x-create-button route="roles.create" label="Ajouter un rôle" />
        @endcan

            <input type="text" id="searchBar" placeholder="Rechercher des utilisateurs..." class="mt-2 mb-4 w-64 px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-gray-900">

        @if (!$roles->isEmpty())
            <x-dynamic-table :headers="['ID', 'Nom', 'Action']">
                @foreach ($roles as $role)
                    <tr class="bg-white border-b hover:bg-gray-50 role-item">
                        <td class="px-6 py-4 text-sm text-neutral-600">{{ $loop->iteration }}</td>
                        <!-- Ajout d'une classe pour faciliter la sélection par JS -->
                        <td class="px-6 py-4 text-sm text-neutral-600 role-name">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-sm text-neutral-600">
                            <x-action-links :showRoute="'roles.show'" :editRoute="'roles.edit'" :deleteRoute="'roles.destroy'" :id="$role->id"/>
                        </td>
                    </tr>
                @endforeach
            </x-dynamic-table>
        @else
            <p class="text-danger text-center py-10">Aucun rôle disponible pour le moment.</p>
        @endif

        {{ $roles->links() }}
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchBar = document.getElementById('searchBar');

        searchBar.addEventListener('keyup', function (e) {
            const term = e.target.value.toLowerCase();
            // Sélectionne tous les éléments de la liste des rôles
            const roles = document.querySelectorAll('.role-item');

            roles.forEach(function (role) {
                const name = role.querySelector('.role-name').textContent;
                // Affiche ou cache les rôles basé sur la recherche
                if (name.toLowerCase().indexOf(term) != -1) {
                    role.style.display = '';
                } else {
                    role.style.display = 'none';
                }
            });
        });
    });
</script>

