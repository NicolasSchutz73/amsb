@php use App\Http\Controllers\CalendarController; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emploi du temps') }}
        </h2>
    </x-slot>

{{--    @if(!($filtre) && $valable)--}}
{{--        <script>--}}
{{--            function hasGetVariable(variableName) {--}}
{{--                const urlParams = new URLSearchParams(window.location.search);--}}
{{--                return urlParams.has(variableName);--}}
{{--            }--}}

{{--            if(!(hasGetVariable('teams'))){--}}
{{--                var teamName = "{{$teamName}}";--}}
{{--                console.log("teamName: ",teamName);--}}
{{--                window.location.href = '/calendar?teams=' + encodeURIComponent(teamName);--}}
{{--            }--}}
{{--        </script>--}}
{{--    @endif--}}


    <div class="container py-12">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <form action="{{ url('calendar') }}" method="GET">
                    @foreach($categories as $category)
                        <div class="form-check">
                            @php
                                if (isset($_GET['teams'])) {
                                   if(in_array($category, $_GET['teams'])){
                                       $check = 'checked';
                                   } else {
                                       $check = '';
                                   }
                                } else {
                                    $check = '';
                                }

                                @endphp
                            <input class="form-check-input" type="checkbox" value="{{ $category }}" id="team{{ $loop->index }}" name="teams[]" {{$check}}>
                            <label class="form-check-label" for="team{{ $loop->index }}">
                                {{ $category }}
                            </label>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Voir les calendriers</button>
                </form>

                <br><br>
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
        }else{
            $eventsData = app(\App\Http\Controllers\EventsController::class)->getEventsByCategory(Request::capture(), '');
        }
    @endphp

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
        #eventModal {
            display: none; /* Cache le modal au chargement de la page */
        }
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
                    var eventObj = info.event;
                    console.log(eventObj)
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
