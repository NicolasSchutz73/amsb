{{--<div class="container my-4">--}}
{{--    <h1 class="mb-4 font-weight-bold text-primary">Détails de l'événement</h1>--}}
{{--    <p class="text-secondary"><strong>Nom :</strong> {{ $event->title }}</p>--}}
{{--    <p class="text-secondary"><strong>Début :</strong> {{ $event->start }}</p>--}}
{{--    <p class="text-secondary"><strong>Fin :</strong> {{ $event->end }}</p>--}}
{{--    <p class="text-secondary"><strong>Lieu :</strong> {{ $event->location }}</p>--}}
{{--    <!-- Ajoutez d'autres détails de l'événement ici selon vos besoins -->--}}
{{--</div>--}}



<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-neutral-900 dark:text-gray-100">Détails de l'équipe</h2>
            <a href="{{ route('calendar') }}" class="inline-flex items-center justify-center text-neutral-900 dark:text-gray-100 py-2 px-4 hover:underline">&larr; Retour</a>
        </div>
    </x-slot>

    <div class="flex justify-center my-8">
        <div class="w-full px-6 xl:w-8/12">
            <div class="p-6 bg-white shadow rounded">
                <span class="block text-neutral-900 font-bold mb-4">Nom :
                    <span class="w-full block text-neutral-600 font-medium py-1"> {{ $event->title }}</span>
                </span>
                <span class="block text-neutral-900 font-bold mb-4">Début :
                    <span class="w-full block text-neutral-600 font-medium py-1">
                        à  {{ \Carbon\Carbon::parse($event->start)->format('H:i') }} le {{ \Carbon\Carbon::parse($event->start)->format('d-m-Y') }}
                    </span>
                </span>


                <span class="block text-neutral-900 font-bold mb-4">Fin :
                    <span class="w-full block text-neutral-600 font-medium py-1">
                        à  {{ \Carbon\Carbon::parse($event->end)->format('H:i') }} le {{ \Carbon\Carbon::parse($event->end)->format('d-m-Y') }}
                    </span>
                </span>
                <span class="block text-neutral-900 font-bold mb-4">Lieu :
                    <span class="w-full block text-neutral-600 font-medium py-1"> {{ $event->location }}</span>
                </span>
            </div>
        </div>
    </div>
</x-app-layout>
