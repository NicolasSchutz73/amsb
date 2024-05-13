
        @php
            $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
            $headers = get_headers($imageUrl);
        @endphp

        @php
            $documentUrl = "http://mcida.eu/AMSB/documents/" . $user->id . ".pdf";
            $headers = get_headers($documentUrl);
        @endphp

<div class="bg-gray-100 min-h-screen">
    <div class="max-w-screen-md mx-auto">
        <!-- Profil Card -->
        <div class="bg-white rounded-lg shadow p-5 mt-1 mb-6 text-center">
            <div class="relative">
                <img class="w-24 h-24 rounded-full mx-auto " src="{{$imageUrl}}" alt="Profil" style="object-fit: cover; aspect-ratio: 1;" >
{{--                <button class="absolute top-0 right-0 bg-blue-500 text-white p-2 rounded-full">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />--}}
{{--                    </svg>--}}
{{--                </button>--}}
            </div>
            <h3 class="mt-2 font-bold">{{ $user->firstname }} {{ $user->lastname }}</h3>
            <p class="text-sm text-gray-600">{{ $user->email }}</p>
        </div>

        <!-- Form for profile details -->
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('patch')
            <!-- Name Fields -->
            <div class="mb-6">
                <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
                <input type="text" id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Adresse e-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Description Field -->
            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <input type="text" id="description" name="description" value="{{ old('description', $user->description) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Emergency Contact Field -->
            <div class="mb-6">
                <label for="emergency" class="block text-gray-700 text-sm font-bold mb-2">Contact(s) d'urgence</label>
                <input type="text" id="emergency" name="emergency" value="{{ old('emergency', $user->emergency) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-nonefocus:shadow-outline">
            </div>
            <!-- Profile Photo Upload Field -->
            <div class="mb-6">
                <label for="profile_photo" class="block text-gray-700 text-sm font-bold mb-2">Photo de profil</label>
                <input type="file" id="profile_photo" name="profile_photo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Profile Photo Preview -->
            <div class="mb-6">
                @if($user->profile_photo)
                    <img src="{{ $user->profile_photo_url }}" alt="Profile Photo" class="img-fluid rounded-md mb-3" style="width: 150px; height: 150px;">
                @@else
                    <img class="img-fluid rounded-md mb-3" src="anonyme.jpeg" alt="Avatar de {{ $user->firstname }}" style="width: 150px; height: 150px;">
                @endif
            </div>

            <!-- Document Upload Field -->
            <div class="mb-6">
                <label for="document" class="block text-gray-700 text-sm font-bold mb-2">Document</label>
                <input type="file" id="document" name="document" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Document Preview/Download Link -->
            @if($user->document_url)
                <div class="mb-6">
                    <a href="{{ $user->document_url }}" class="inline-block px-4 py-2 text-base font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 transition duration-150 ease-in-out">
                        Télécharger le document
                    </a>
                </div>
            @else
                <p class="text-red-500 mb-3">Aucun document disponible.</p>
            @endif

            <!-- Save Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
