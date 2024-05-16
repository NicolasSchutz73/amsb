<form action="{{ route('profile.upload_photos') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="photos" class="block text-gray-700 text-sm font-bold mb-2">Télécharger des photos</label>
        <input type="file" id="photos" name="photos[]" multiple class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Télécharger
        </button>
    </div>
</form>

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
