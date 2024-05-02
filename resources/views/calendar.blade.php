<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emploi du temps') }}
        </h2>
    </x-slot>

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
            var events = {!! json_encode($events->map(function($event) {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'location' => $event->location,
            'start' => $event->start,
            'end' => $event->end,
            'isRecurring' => $event->isRecurring,
        ];
    })->toArray(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

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
                    $('#messPageLink').attr('href', '/chat-room-users/' + eventObj.id);
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
                    return {
                        html: '<div>' + arg.event.title + '</div>',
                    };
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
