<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Emploi du temps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                locale: 'fr', // Utilisez le français comme langue
                firstDay: 1,  // Définissez le premier jour de la semaine comme lundi (0 pour dimanche, 1 pour lundi, etc.)
                headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay, listWeek'
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
