@php use App\Http\Controllers\CalendarController; @endphp
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

            if(!(hasGetVariable('category'))){
                var teamName = "{{$teamName}}";
                console.log("teamName: ",teamName);
                window.location.href = '/calendar?category=' + encodeURIComponent(teamName);
            }
        </script>
    @endif

    <div class="container py-12">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <select id="category-filter" onchange="changeCategory()">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        @if(isset($_GET['category']))
                            @if($category == $_GET['category'])
                                <option value="{{ $category }}" selected>{{ $category }}</option>
                            @else
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endif
                        @else
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endif
                    @endforeach
                </select>

                <br><br>
                @php
                    if (isset($_GET['category'])) {
                        $eventsData = app(\App\Http\Controllers\EventsController::class)->getEventsByCategory(Request::capture(), $_GET['category']);
                    }else{
                        $eventsData = app(\App\Http\Controllers\EventsController::class)->getEventsByCategory(Request::capture(), '');
                    }
                @endphp
                <div id='calendar'></div>
            </div>
        </div>
    </div>

    <style>
        /* CSS personnalisé pour FullCalendar en mode responsive */
        @media (max-width: 767px) {
            #calendar{
                margin: 15px;
            }

            select{
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

    </style>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.js'></script>
    <script src='fullcalendar/locales/fr.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            @php
                // Récupération de la réponse JSON
                $responseData = json_decode($eventsData->getContent(), true);
//                dd($responseData);
                // Initialisation du tableau pour stocker les événements
                $events = [];
                foreach ($responseData['data'] as $item) {
                    $event = $item['event'];
                    $event['backgroundColor'] = $item['colors'][0] ?? '#ccc'; // Couleur par défaut si aucune couleur n'est définie
                    $events[] = $event;
                }
            @endphp

            var events = {!! json_encode($events) !!};

            console.log(events)

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                eventClick: function(info) {
                    window.location.href = '/event/' + info.event.id;
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
                    today:    'Aujourd\'hui',
                    month:    'Mois',
                    week:     'Semaine',
                    day:      'Jour',
                    list:     'Liste'
                },
                buttonIcons: {
                    prev: 'chevrons-left',
                    next: 'chevrons-right'
                },
                initialView: 'timeGridWeek',
                events: events,
                eventContent: function(arg) {
                    var element = document.createElement('div');
                    element.innerText = arg.event.title;
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



    </script>
</x-app-layout>
