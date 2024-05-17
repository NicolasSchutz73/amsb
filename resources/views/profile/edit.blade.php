<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    @php
        $imageUrl = "https://mcida.fr/AMSB/profile/" . $user->id . ".jpg";
        $headers = get_headers($imageUrl);
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="bg-white rounded-lg shadow p-5 mt-1 mb-6 text-center">
                    <div class="relative">
                        <img class="w-24 h-24 rounded-full mx-auto " src="{{$imageUrl}}" alt="Profil" style="object-fit: cover; aspect-ratio: 1;" >
                    </div>
                    <h3 class="mt-2 font-bold">{{ $user->firstname }} {{ $user->lastname }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.add-pictures-into-profile')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
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
    </script>
</x-app-layout>
