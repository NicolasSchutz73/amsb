<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emploi du temps') }}
        </h2>
    </x-slot>

    @if(!($filtre) && $valable)
        <script>
            function hasGetVariable(variableName) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.has(variableName);
            }

            if(!(hasGetVariable('teams'))){
                var teamName = "{{$teamName}}";
                console.log("teamName: ",teamName);
                window.location.href = '/calendar?teams%5B%5D=' + encodeURIComponent(teamName);
            }
        </script>
    @endif

    <div class="container py-12">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="form-container">
                    <button id="toggleFormButton" class="btn btn-info" onclick="toggleForm()">
                        <span id="arrowIcon" class="arrow down"></span> Ajouter des équipes
                    </button>
                    <form id="dynamicForm" action="{{ url('calendar') }}" method="GET" style="display: none; overflow: hidden; transition: max-height 0.5s ease; height: 425px !important;">
                        <input type="text" id="searchBox" placeholder="Rechercher une équipe..." class="form-control mb-3">
                        <div class="scroll-container">
                            @foreach($categories as $category)
                                <div class="card-check {{ in_array($category, request()->get('teams', [])) ? 'checked' : '' }}" data-team-name="{{ strtolower($category) }}">
                                    <input type="checkbox" value="{{ $category }}" id="team{{ $loop->index }}" name="teams[]" {{ in_array($category, request()->get('teams', [])) ? 'checked' : '' }}>
                                    <label for="team{{ $loop->index }}">
                                        {{ $category }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <select name="place_filter" id="placeFilter" class="form-control mt-3" onchange="updatePlaceOptions()">
                            <option value="both" {{ request()->get('place_filter') == 'both' ? 'selected' : '' }}>Les deux</option>
                            <option value="domicile" {{ request()->get('place_filter') == 'domicile' ? 'selected' : '' }}>Domicile</option>
                            <option value="exterieur" {{ request()->get('place_filter') == 'exterieur' ? 'selected' : '' }}>Extérieur</option>
                        </select>
                        <select name="domicile_place" id="domicilePlace" class="form-control mt-3" style="display: none;">
                            <option value="aix les bains" {{ request()->get('domicile_place') == 'aix les bains' ? 'selected' : '' }}>Aix les bains</option>
                            <option value="aiguebelle" {{ request()->get('domicile_place') == 'aiguebelle' ? 'selected' : '' }}>Aiguebelle</option>
                            <option value="both" {{ request()->get('domicile_place') == 'both' ? 'selected' : '' }}>Les deux</option>
                        </select>
                        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Voir les calendriers</button>
                    </form>
                </div>
                <br>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Détails de l'événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 id="eventTitle"></h6>
                    <p id="eventDescription"></p>
                    <p id="eventLocation"></p>
                    <p>Commence: <span id="eventStart"></span></p>
                    <p>Fin: <span id="eventEnd"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a href="" id="eventPageLink" class="btn btn-primary">Voir la page de l'événement</a>
                    <a href="" id="messPageLink" class="btn btn-primary">Accéder à la messagerie</a>
                </div>
            </div>
        </div>
    </div>

    @php
        if (isset($_GET['teams'])) {
            $eventsData = app(\App\Http\Controllers\EventsController::class)->getEventsByCategory(Request::capture(), $_GET['teams']);
        }else {
            // Sinon, retourner un tableau JSON vide
            $eventsData = response()->json(['data' => []]);
        }
    @endphp

    <style>
        /* CSS personnalisé pour FullCalendar en mode responsive */
        @media (max-width: 767px) {

            .btn-info {
                width: 100% !important;
                background-color: white !important;
                display: flex !important;
                flex-direction: row-reverse !important;
                justify-content: space-around !important;
                align-items: center;
                border: none !important;
                margin-bottom: 10px;
            }
            .btn-info:hover {
                border: none;
            }
            .arrow {
                border: solid black;
                border-width: 0 2px 2px 0;
                display: inline-block;
                padding: 3px;
                margin-left: 5px;
                vertical-align: middle;
            }
            .down {
                transform: rotate(45deg);
                -webkit-transform: rotate(45deg);
            }
            .up {
                transform: rotate(-135deg);
                -webkit-transform: rotate(-135deg);
            }
            .form-container {
                margin-bottom: 20px;
            }
            .scroll-container {
                max-height: 200px;
                overflow-y: auto;
                padding: 15px;
                border: 1px solid #ccc;
                border-radius: 8px;
                margin-top: 20px;
            }
            button[type="submit"] {
                width: 100%; /* Rend le bouton aussi large que son conteneur */
                display: block; /* S'assure que le bouton s'affiche comme un bloc */
            }
            .card-check {
                border: 1px solid #ccc;
                padding: 10px;
                border-radius: 8px;
                display: block;
                margin-bottom: 10px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .card-check input[type="checkbox"] {
                display: none; /* Cache la checkbox, mais elle est toujours fonctionnelle */
            }
            .card-check.checked {
                background-color: #b0e0a1; /* Couleur lors de la sélection */
            }
            .card-check:hover {
                background-color: #b0e0a1; /* Couleur au survol si pas sélectionnée */
            }
            #calendar {
                margin: 15px 0;
            }
            select {
                width: 75%;
                margin: 0 12.5%;
            }
            .fc-header-toolbar {
                flex-direction: column;
            }
            .fc-toolbar-title {
                font-size: 1.5rem !important; /* Taille de texte plus petite */
                margin-bottom: 0.5rem !important; /* Ajoute un peu d'espace en dessous du titre */
            }
            .fc-button-group > .fc-button, .fc-button {
                font-size: 0.8rem; /* Réduit la taille de texte des boutons */
                padding: 0.25rem 0.5rem; /* Réduit le padding des boutons */
            }
            .fc-button-group {
                margin-bottom: 0.5rem; /* Ajoute de l'espace sous les boutons de groupe */
            }
            /* Ajuste les vues spécifiques si nécessaire */
            .fc-dayGridMonth-view, .fc-timeGridWeek-view, .fc-timeGridDay-view {
                /* Styles spécifiques aux vues */
            }
        }
        #eventModal {
            display: none; /* Cache le modal au chargement de la page */
        }
        a { text-decoration: none !important; }
    </style>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.js'></script>
    <script src='fullcalendar/locales/fr.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function formatDate(dateStr) {
            let date = new Date(dateStr);
            let day = date.getDate().toString().padStart(2, '0');
            let month = (date.getMonth() + 1).toString().padStart(2, '0');
            let year = date.getFullYear();
            let hours = date.getHours().toString().padStart(2, '0');
            let minutes = date.getMinutes().toString().padStart(2, '0');
            return `${day}/${month}/${year} à ${hours}:${minutes}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            @php
                $responseData = json_decode($eventsData->getContent(), true);
                $events = [];
                foreach ($responseData['data'] as $item) {
                    $event = $item['event'];
                    $event['backgroundColor'] = $item['colors'][0] ?? '#ccc';
                    $events[] = $event;
                }
            @endphp

            var events = {!! json_encode($events) !!};
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                eventClick: function(info) {
                    var eventObj = info.event;
                    $('#eventTitle').text(eventObj.title);
                    $('#eventDescription').text(eventObj.extendedProps.description);
                    $('#eventLocation').text(eventObj.extendedProps.location);
                    $('#eventStart').text(formatDate(eventObj.start.toISOString()));
                    $('#eventEnd').text(formatDate(eventObj.end.toISOString()));
                    $('#eventPageLink').attr('href', '/event/' + eventObj.id);
                    $('#messPageLink').attr('href', '/chat-room-users');
                    $('#eventModal').modal('show');
                },
                height: 'auto',
                locale: 'fr',
                firstDay: 1,
                slotMinTime: '08:00:00',
                slotMaxTime: '24:00:00',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour',
                    list: 'Liste'
                },
                buttonIcons: {
                    prev: 'chevrons-left',
                    next: 'chevrons-right'
                },
                initialView: 'timeGridWeek',
                views: {
                    timeGridWeek: {
                        dayHeaderFormat: { weekday: 'short' }
                    }
                },
                events: events,
                eventContent: function(arg) {
                    var element = document.createElement('div');
                    element.innerText = "(" + arg.event.extendedProps.description + ") " + arg.event.title;
                    element.style.backgroundColor = arg.event.backgroundColor;
                    element.style.color = '#ffffff';
                    return { domNodes: [element] };
                },
            });

            calendar.render();
        });

        function changeCategory() {
            var category = document.getElementById('category-filter').value;
            if(category !== 'AllCategory' || category !== ''){
                window.location.href = '/calendar?category=' + encodeURIComponent(category);
            }
        }

        document.querySelectorAll('.card-check').forEach(function(card) {
            card.addEventListener('click', function() {
                var checkbox = this.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked; // Change l'état de la checkbox
                this.classList.toggle('checked', checkbox.checked); // Ajoute/retire la classe 'checked'
            });
        });

        document.getElementById('searchBox').addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            var cards = document.querySelectorAll('.card-check');

            cards.forEach(function(card) {
                var teamName = card.getAttribute('data-team-name');
                if (teamName.includes(searchQuery)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function toggleForm() {
            var form = document.getElementById('dynamicForm');
            var arrowIcon = document.getElementById('arrowIcon');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                form.style.maxHeight = form.scrollHeight + 'px';
                arrowIcon.classList.remove('down');
                arrowIcon.classList.add('up');
            } else {
                form.style.display = 'none';
                form.style.maxHeight = '0';
                arrowIcon.classList.remove('up');
                arrowIcon.classList.add('down');
            }
        }

        function updatePlaceOptions() {
            var placeFilter = document.getElementById('placeFilter').value;
            var domicilePlace = document.getElementById('domicilePlace');
            if (placeFilter === 'domicile') {
                domicilePlace.style.display = 'block';
            } else {
                domicilePlace.style.display = 'none';
            }
        }

        // Initial call to ensure the correct display based on initial selection
        updatePlaceOptions();

    </script>
</x-app-layout>
