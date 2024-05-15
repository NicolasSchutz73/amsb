<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-neutral-900 dark:text-gray-100">
                @if (count($teamDetails) > 1)
                    Mes équipes
                @else
                    Mon équipe
                @endif
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center text-neutral-900 dark:text-gray-100 py-2 px-4 hover:underline">&larr; Retour</a>
        </div>
    </x-slot>

    @if (!empty($teamDetails))
        <div class="w-full bg-white">
            <!-- Boutons pour sélectionner les équipes -->
            <div class="flex justify-start w-ful container mx-auto px-4">
                @foreach ($teamDetails as $index => $teamDetail)
                    <button id="teamButton{{ $index }}" class="team-button px-1 mx-2 text-neutral-900 dark:text-gray-100 font-bold relative">{{ $teamDetail['team']->name }}</button>
                @endforeach
            </div>
        </div>

        @foreach ($teamDetails as $index => $teamDetail)
            <!-- Détails de l'équipe -->
            <div id="teamDetails{{ $index }}" class="team-details {{ $index === 0 ? '' : 'invisible' }}">
                <!-- Bandeau pour le nom et la catégorie de l'équipe -->
                <div class="w-full bg-white py-8">
                    <div class="container mx-auto px-4">
                        <div class="text-center">
                            <span class="block text-neutral-900 font-bold text-3xl mb-2">{{ $teamDetail['team']->name }}</span>
                            <span class="block text-neutral-600 font-medium text-xl">{{ $teamDetail['team']->category }}</span>
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
                        <div id="effectif{{ $index }}" class="tab-content visible">
                            <h3 class="font-bold text-2xl mb-8">Joueurs</h3>
                            @forelse ($teamDetail['users'] as $user)
                                @if ($user->hasRole('joueur'))
                                    @php
                                        $imageUrl = "http://mcida.eu/AMSB/profile/" . $user->id . ".jpg";
                                        $headers = get_headers($imageUrl);
                                    @endphp

                                    <div class="flex items-center mb-2">
                                        @if (strpos($headers[0], '200') !== false)
                                            <img class="w-10 h-10 rounded-full mr-4" src="{{ $imageUrl }}" alt="Photo de profil de {{ $user->firstname }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
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

                                <div class="flex items-center mb-2">
                                    @if (strpos($headers[0], '200') !== false)
                                        <img class="w-10 h-10 rounded-full mr-4" src="{{ $imageUrl }}" alt="Photo de profil de {{ $coach->firstname }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
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

                                    <div class="flex items-center mb-2">
                                        @if (strpos($headers[0], '200') !== false)
                                            <img class="w-10 h-10 rounded-full mr-4" src="{{ $imageUrl }}" alt="Photo de profil de {{ $user->firstname }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full mr-4 bg-gray-200 flex items-center justify-center">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const teamButtons = document.querySelectorAll('.team-button');
            const teamDetails = document.querySelectorAll('.team-details');
            const tabButtons = document.querySelectorAll('.tab-button');

            teamButtons.forEach((button, index) => {
                button.addEventListener('click', function () {
                    teamDetails.forEach((details, idx) => {
                        if (index === idx) {
                            details.classList.remove('invisible');
                            details.classList.add('visible');
                            details.querySelectorAll('.tab-content').forEach(content => content.classList.add('visible'));
                        } else {
                            details.classList.remove('visible');
                            details.classList.add('invisible');
                            details.querySelectorAll('.tab-content').forEach(content => content.classList.remove('visible'));
                        }
                    });
                    teamButtons.forEach(btn => btn.classList.remove('active-team'));
                    button.classList.add('active-team');
                });
            });

            tabButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const target = this.dataset.target;
                    const parent = this.closest('.team-details');
                    parent.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                    parent.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('visible');
                        content.classList.add('invisible');
                    });
                    this.classList.add('active');
                    parent.querySelector('#' + target).classList.add('visible');
                    parent.querySelector('#' + target).classList.remove('invisible');
                });
            });

            // Set default active team and tab
            if (document.querySelector('.team-button')) {
                document.querySelector('.team-button').click();
            }
            if (document.querySelector('.tab-button')) {
                document.querySelector('.tab-button').click();
            }
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
    </style>
</x-app-layout>
