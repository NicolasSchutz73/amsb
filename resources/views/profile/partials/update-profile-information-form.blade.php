{{--<section>--}}
{{--    <header>--}}
{{--        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">--}}
{{--            {{ __('Profile Information') }}--}}
{{--        </h2>--}}

{{--        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">--}}
{{--            {{ __("Update your account's profile information and email address.") }}--}}
{{--        </p>--}}
{{--    </header>--}}

{{--    <form id="send-verification" method="post" action="{{ route('verification.send') }}" >--}}
{{--        @csrf--}}
{{--    </form>--}}

{{--    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">--}}
{{--        @csrf--}}
{{--        @method('patch')--}}

{{--        <div>--}}
{{--            <x-input-label for="firstname" :value="__('Prénom')" />--}}
{{--            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full" :value="old('firstname', $user->firstname)" required autofocus autocomplete="name" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="lastname" :value="__('Nom')" />--}}
{{--            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)" required autofocus autocomplete="name" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="email" :value="__('Adresse e-mail')" />--}}
{{--            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('email')" />--}}

{{--            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())--}}
{{--                <div>--}}
{{--                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">--}}
{{--                        {{ __('Your email address is unverified.') }}--}}

{{--                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">--}}
{{--                            {{ __('Click here to re-send the verification email.') }}--}}
{{--                        </button>--}}
{{--                    </p>--}}

{{--                    @if (session('status') === 'verification-link-sent')--}}
{{--                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">--}}
{{--                            {{ __('A new verification link has been sent to your email address.') }}--}}
{{--                        </p>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="description" :value="__('Description')" />--}}
{{--            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $user->description)" autofocus autocomplete="name" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('description')" />--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="emergency" :value="__('Contact(s) d\'urgence')" />--}}
{{--            <x-text-input id="emergency" name="emergency" type="text" class="mt-1 block w-full" :value="old('emergency', $user->emergency)" autofocus autocomplete="name" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('emergency')" />--}}
{{--        </div>--}}

{{--        <div class="mb-4">--}}
{{--            <label for="profile_photo" class="text-gray-500 dark:text-gray-400 block text-md-end text-start">Photo de profil</label>--}}
{{--            <div class="mb-4">--}}
{{--                <label for="profile_photo" class="block text-sm font-medium text-gray-700">Choisir une photo de profil</label>--}}
{{--                <input type="file" class="mt-1 p-2 border rounded-md w-full focus:outline-none focus:ring focus:border-blue-300" id="profile_photo" name="profile_photo">--}}
{{--            </div>--}}
{{--        </div>--}}

        @php
            $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
            $headers = get_headers($imageUrl);
        @endphp

{{--        @if (strpos($headers[0], '200') !== false)--}}
{{--            <img src="{{ $imageUrl }}" alt="Photo de profil" class="img-fluid rounded" style="width: 150px; height: 150px; border: 2px solid #fff; clip-path:ellipse(50% 50%);">--}}
{{--        @else--}}
{{--            <div class="mt-1 text-red-500 dark:text-red-40">--}}
{{--                Aucune photo de profil disponible--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="mb-4">--}}
{{--            <label for="document" class="text-gray-500 dark:text-gray-400 block text-md-end text-start">Document</label>--}}
{{--            <div class="mb-4">--}}
{{--                <label for="document" class="block text-sm font-medium text-gray-700">Choisir un document</label>--}}
{{--                <input type="file" class="mt-1 p-2 border rounded-md w-full focus:outline-none focus:ring focus:border-blue-300" id="document" name="document">--}}
{{--            </div>--}}
{{--        </div>--}}

        @php
            $documentUrl = "http://mcida.eu/AMSB/documents/" . $user->id . ".pdf";
            $headers = get_headers($documentUrl);
        @endphp

{{--        @if (strpos($headers[0], '200') !== false)--}}
{{--            <!-- Affichez le document comme vous le souhaitez (par exemple, un lien de téléchargement) -->--}}
{{--            <a href="{{ $documentUrl }}" target="_blank" class="inline-block px-4 py-2 mt-2 text-base font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue focus:border-blue-700 active:bg-blue-800 transition duration-150 ease-in-out">--}}
{{--                Télécharger le document--}}
{{--            </a>--}}
{{--        @else--}}
{{--            <div class="mt-1 text-red-500 dark:text-red-40">--}}
{{--                Aucun document disponible--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="flex items-center gap-4">--}}
{{--            <x-primary-button>{{ __('Save') }}</x-primary-button>--}}

{{--            @if (session('status') === 'profile-updated')--}}
{{--                <p--}}
{{--                    x-data="{ show: true }"--}}
{{--                    x-show="show"--}}
{{--                    x-transition--}}
{{--                    x-init="setTimeout(() => show = false, 2000)"--}}
{{--                    class="text-sm text-gray-600 dark:text-gray-400"--}}
{{--                >{{ __('Saved.') }}</p>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </form>--}}
{{--</section>--}}

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
