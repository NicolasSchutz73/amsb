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
            // Encodage direct en JSON sans JSON.parse
            var events = {!! json_encode($events->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'location' => $event->location,
                'start' => $event->start,
                'end' => $event->end,
                'isRecurring' => $event->isRecurring,
                // Ajoutez ici d'autres propriétés nécessaires pour FullCalendar
            ];
        })->toArray(), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

            console.log(events);

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                eventClick: function(info) {
                    // Redirection vers une autre page avec l'ID de l'événement
                    window.location.href = '/event/' + info.event.id; // Adapter la route selon votre structure de routes
                },
                windowResize: function(view) {
                    if (window.innerWidth < 768) { // ou une autre taille de breakpoint
                        calendar.changeView('listWeek');
                    } else {
                        calendar.changeView('dayGridMonth');
                    }
                },
                height: 'auto',
                locale: 'fr', // Utilisez le français comme langue
                firstDay: 1,  // Définissez le premier jour de la semaine comme lundi (0 pour dimanche, 1 pour lundi, etc.)
                slotMinTime: '08:00:00', // Heure de début à 8h du matin
                slotMaxTime: '24:00:00', // Heure de fin à minuit
                headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            buttonText: { // Personnalisez les textes des boutons ici
                today:    'Aujourd\'hui',
                month:    'Mois',
                week:     'Semaine',
                day:      'Jour',
                list:     'Liste'
            },
                initialView: 'dayGridMonth', // This will show the month view with blocks
                events: events,
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
