<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-white">
                @if (count($teamDetails) > 1)
                    Mes équipes
                @else
                    Mon équipe
                @endif
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center text-white py-2 px-4 hover:underline">&larr; Retour</a>
        </div>
    </x-slot>

    @if (!empty($teamDetails))
        <div class="w-full bg-white">
            <!-- Boutons pour sélectionner les équipes -->
            <div class="flex justify-start w-ful container mx-auto px-4 pt-8">
                @foreach ($teamDetails as $index => $teamDetail)
                    <button id="teamButton{{ $index }}" class="team-button px-1 mx-2 text-neutral-900 dark:text-gray-100 font-bold relative">{{ $teamDetail['team']->name }}</button>
                @endforeach
            </div>
        </div>

        @foreach ($teamDetails as $index => $teamDetail)
            <!-- Détails de l'équipe -->
            <div id="teamDetails{{ $index }}" class="team-details {{ $index === 0 ? '' : 'invisible' }}">
                <!-- Bandeau pour le nom et la catégorie de l'équipe -->
                <div class="w-full bg-white py-16">
                    <div class="container mx-auto px-4">
                        <div class="text-center">
                            <span class="block text-neutral-900 font-bold text-3xl mb-2">Équipe {{ $teamDetail['team']->name }}</span>
                            <span class="block text-gray-500 dark:text-gray-400 font-medium text-lg">Catégorie {{ $teamDetail['team']->category }}</span>
                        </div>
                    </div>
                </div>

                <!-- Bandeau pour les boutons -->
                <div class="w-full h-40 bg-neutral-100 flex items-center">
                    <div class="container mx-auto px-4">
                        <div class="flex justify-center space-x-0">
                            <button class="tab-button px-4 py-3 border border-gray-300 text-gray-500 rounded-l shadow font-bold active" data-target="effectif{{ $index }}">Effectif</button>
                            <button class="tab-button px-4 py-3 border-t border-b border-gray-300 text-gray-500 shadow font-bold" data-target="staff{{ $index }}">Staff</button>
                            <button class="tab-button px-4 py-3 border border-gray-300 text-gray-500 rounded-r shadow font-bold" data-target="parents{{ $index }}">Parents</button>
                        </div>
                    </div>
                </div>

                <!-- Bandeau pour la liste des utilisateurs -->
                <div class="w-full bg-white py-6">
                    <div class="container mx-auto px-4">
                        <div id="effectif{{ $index }}" class="tab-content {{ $index === 0 ? 'visible' : 'invisible' }}">
                            <h3 class="font-bold text-2xl mb-8">Joueurs</h3>
                            @forelse ($teamDetail['users'] as $user)
                                @if ($user->hasRole('joueur'))
                                    @php
                                        $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
                                        $headers = get_headers($imageUrl);
                                    @endphp

                                    <div class="flex items-center mb-2 cursor-pointer" data-modal-target="user-modal{{ $user->id }}" data-modal-toggle="user-modal{{ $user->id }}">
                                        @if (strpos($headers[0], '200') !== false)
                                            <img class="w-12 h-12 rounded-full mr-4 object-cover object-center" src="{{ $imageUrl }}" alt="Photo de profil de {{ $user->firstname }}">
                                        @else
                                            <div class="w-12 h-12 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">N/A</span>
                                            </div>
                                        @endif
                                        <span>{{ $user->firstname }} {{ $user->lastname }}</span>
                                    </div>
                                @endif
                            @empty
                                <p>Aucun joueur dans cette équipe pour le moment.</p>
                            @endforelse
                        </div>

                        <div id="staff{{ $index }}" class="tab-content invisible">
                            <h3 class="font-bold text-2xl mb-8">
                                @if ($teamDetail['coaches']->count() === 1)
                                    Entraineur
                                @elseif ($teamDetail['coaches']->count() > 1)
                                    Entraineurs
                                @else
                                    Entraineur
                                @endif
                            </h3>
                            @forelse ($teamDetail['coaches'] as $coach)
                                @php
                                    $imageUrl = "http://mcida.eu/AMSB/profile/" . $coach->id . ".jpg";
                                    $headers = get_headers($imageUrl);
                                @endphp

                                <div class="flex items-center mb-2 cursor-pointer" data-modal-target="user-modal{{ $coach->id }}" data-modal-toggle="user-modal{{ $coach->id }}">
                                    @if (strpos($headers[0], '200') !== false)
                                        <img class="w-12 h-12 rounded-full mr-4 object-cover object-center" src="{{ $imageUrl }}" alt="Photo de profil de {{ $coach->firstname }}">
                                    @else
                                        <div class="w-12 h-12 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">N/A</span>
                                        </div>
                                    @endif
                                    <span>{{ $coach->firstname }} {{ $coach->lastname }}</span>
                                </div>
                            @empty
                                <p>Aucun entraîneur dans cette équipe pour le moment.</p>
                            @endforelse
                        </div>

                        <div id="parents{{ $index }}" class="tab-content invisible">
                            <h3 class="font-bold text-2xl mb-8">Parents</h3>
                            @forelse ($teamDetail['users'] as $user)
                                @if ($user->hasRole('parents'))
                                    @php
                                        $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
                                        $headers = get_headers($imageUrl);
                                    @endphp

                                    <div class="flex items-center mb-2 cursor-pointer" data-modal-target="user-modal{{ $user->id }}" data-modal-toggle="user-modal{{ $user->id }}">
                                        @if (strpos($headers[0], '200') !== false)
                                            <img class="w-12 h-12 rounded-full mr-4 object-cover object-center" src="{{ $imageUrl }}" alt="Photo de profil de {{ $user->firstname }}">
                                        @else
                                            <div class="w-12 h-12 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500">N/A</span>
                                            </div>
                                        @endif
                                        <span>{{ $user->firstname }} {{ $user->lastname }}</span>
                                    </div>
                                @endif
                            @empty
                                <p>Aucun parent dans cette équipe pour le moment.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Overlay -->
    <div id="modal-overlay" class="hidden fixed top-0 left-0 w-full h-full bg-gray-900 opacity-50 z-40"></div>

    <!-- Modals Section -->
    @foreach ($teamDetails as $index => $teamDetail)
        @foreach ($teamDetail['users'] as $user)
            @if ($user->hasRole('joueur') || $user->hasRole('parents') || $user->hasRole('coach'))
                @php
                    $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
                    $headers = get_headers($imageUrl);
                @endphp

                <div id="user-modal{{ $user->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <div class="flex items-center">
                                    @if (strpos($headers[0], '200') !== false)
                                        <img class="w-16 h-16 rounded-full mr-4 object-cover object-center" src="{{ $imageUrl }}" alt="Photo de profil de {{ $user->firstname }}">
                                    @else
                                        <div class="w-16 h-16 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">N/A</span>
                                        </div>
                                    @endif
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $user->firstname }} {{ $user->lastname }}
                                    </h3>
                                </div>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="user-modal{{ $user->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                    E-mail : {{ $user->email }}
                                </p>
                                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                    Contact d'urgence : {{ $user->emergency }}
                                </p>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button data-modal-hide="user-modal{{ $user->id }}" type="button" class="text-white bg-red-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sélectionne tous les boutons d'équipe et les éléments de détails de l'équipe
            const teamButtons = document.querySelectorAll('.team-button');
            const teamDetails = document.querySelectorAll('.team-details');
            const tabButtons = document.querySelectorAll('.tab-button');
            const modalOverlay = document.getElementById('modal-overlay');

            // Ajoute un gestionnaire d'événements 'click' à chaque bouton d'équipe
            teamButtons.forEach((button, index) => {
                button.addEventListener('click', function () {
                    // Pour chaque ensemble de détails de l'équipe
                    teamDetails.forEach((details, idx) => {
                        if (index === idx) {
                            // Affiche les détails de l'équipe correspondant au bouton cliqué
                            details.classList.remove('invisible');
                            details.classList.add('visible');
                            // Affiche l'onglet actif pour cette équipe avec un léger délai
                            const activeTabContent = details.querySelector('.tab-content.visible');
                            if (activeTabContent) {
                                activeTabContent.classList.remove('invisible');
                                setTimeout(() => activeTabContent.classList.add('visible'), 50);
                            } else {
                                const defaultTabContent = details.querySelector('.tab-content');
                                defaultTabContent.classList.remove('invisible');
                                setTimeout(() => defaultTabContent.classList.add('visible'), 50);
                            }
                        } else {
                            // Cache les autres détails de l'équipe
                            details.classList.remove('visible');
                            details.classList.add('invisible');
                            details.querySelectorAll('.tab-content').forEach(content => content.classList.remove('visible'));
                        }
                    });
                    // Active visuellement le bouton d'équipe cliqué et désactive les autres
                    teamButtons.forEach(btn => btn.classList.remove('active-team'));
                    button.classList.add('active-team');
                });
            });

            // Ajoute un gestionnaire d'événements 'click' à chaque bouton d'onglet
            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Récupère l'ID cible de l'onglet à afficher
                    const target = this.dataset.target;
                    const parent = this.closest('.team-details');
                    // Désactive tous les boutons d'onglet
                    parent.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                    // Cache tout le contenu des onglets
                    parent.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('visible');
                        content.classList.add('invisible');
                    });
                    // Active visuellement le bouton d'onglet cliqué
                    this.classList.add('active');
                    // Affiche le contenu de l'onglet cible après un léger délai
                    const targetContent = parent.querySelector('#' + target);
                    setTimeout(() => {
                        targetContent.classList.remove('invisible');
                        setTimeout(() => targetContent.classList.add('visible'), 50);
                    }, 50);
                });
            });

            // Définit l'équipe et l'onglet par défaut comme actifs lors du chargement de la page
            if (document.querySelector('.team-button')) {
                document.querySelector('.team-button').click();
            }
            if (document.querySelector('.tab-button')) {
                document.querySelector('.tab-button').click();
            }

            // Gestion des modals
            const modalToggles = document.querySelectorAll('[data-modal-toggle]');
            const modals = document.querySelectorAll('[data-modal-hide]');

            modalToggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const modalId = toggle.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        modalOverlay.classList.remove('hidden');
                        modalOverlay.classList.add('flex');
                    }
                });
            });

            modals.forEach(hide => {
                hide.addEventListener('click', function () {
                    const modalId = hide.getAttribute('data-modal-hide');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                        modalOverlay.classList.remove('flex');
                        modalOverlay.classList.add('hidden');
                    }
                });
            });
        });
    </script>

    <style>
        .invisible {
            display: none;
        }
        .visible {
            display: block;
        }
        .active {
            background-color: #ffffff; /* Active button background color */
            color: #000000; /* Active button text color */
            border-color: rgb(212 212 212); /* Active button border color */
        }

        .active-team::after, .team-button:hover::after {
            opacity: 1;
            transform: translateY(6px);
        }

        .team-button::after {
            background-color: #d81e00;
            bottom: 0;
            content: "";
            height: 2px;
            left: 0;
            opacity: 0;
            position: absolute;
            transform: translateY(12px);
            transition: opacity .2s ease-in-out, transform .2s ease-in-out;
            width: 100%;
        }

        .active-team {
            position: relative; /* Required for the ::after pseudo-element */
        }

        .active-team::after {
            opacity: 1; /* Ensure the ::after element is always visible */
            transform: translateY(6px); /* Ensure the ::after element is in the correct position */
        }

        button {
            background-color: transparent; /* Inactive button background color */
            color: #6b7280; /* Inactive button text color */
            border-color: #d1d5db; /* Inactive button border color */
            position: relative; /* Required for the ::after pseudo-element */
        }

        .tab-content {
            transition: transform 0.5s ease, opacity 0.5s ease;
            transform: translateY(20px);
            opacity: 0;
        }

        .tab-content.visible {
            transform: translateY(0);
            opacity: 1;
        }

        .flex {
            display: flex;
        }

        .hidden {
            display: none;
        }

        /* Styles for the modal overlay */
        #modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 40; /* Ensure it is below the modal but above other content */
        }
    </style>
</x-app-layout>
