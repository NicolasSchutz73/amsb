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

        <input type="text" id="searchBar" placeholder="Rechercher des rôles..." class="mt-2 mb-4 w-64 px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-gray-900">

        @if (!$roles->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($roles as $role)
                    <div class="bg-white rounded-lg shadow-md p-6 role-item">
                        <h2 class="text-xl font-semibold role-name">{{ $role->name }}</h2>
                        <div class="mt-4">
                            <a href="{{ route('roles.show', $role->id) }}" class="text-blue-500 hover:text-blue-700">Voir</a>
                            <a href="{{ route('roles.edit', $role->id) }}" class="text-yellow-500 hover:text-yellow-700 ml-4">Modifier</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
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
            const roles = document.querySelectorAll('.role-item');

            roles.forEach(function (role) {
                const name = role.querySelector('.role-name').textContent.toLowerCase();
                if (name.includes(term)) {
                    role.style.display = '';
                } else {
                    role.style.display = 'none';
                }
            });
        });
    });
</script>
