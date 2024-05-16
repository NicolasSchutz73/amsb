<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Google_Client;
use Google_Service_Calendar;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

// Importez la classe Event

class EventsController extends Controller
{

    public function getEvents(Request $request): \Google\Service\Calendar\Event
    {
        $client = new Google_Client();
        $client->setAuthConfig(config_path('google/credentials.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setDeveloperKey('AIzaSyCxxKnWhC3mcOalpB-FCWJoA9Kg9jSCnPs');

        $service = new Google_Service_Calendar($client);
        $calendarId = 'charriersim@gmail.com'; // Remplacez par l'ID de votre calendrier
        $optParams = [
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        foreach ($events as $event) {
            $startDateTime = $event->getStart()->dateTime;
            $endDateTime = $event->getEnd()->dateTime;

            // Convertir les dates au format MySQL si elles ne sont pas nulles
            $start = $startDateTime ? Carbon::parse($startDateTime)->format('Y-m-d H:i:s') : null;
            $end = $endDateTime ? Carbon::parse($endDateTime)->format('Y-m-d H:i:s') : null;

            // Check Domicile/Extérieur
            $place = null;
            $ListeLieuxA = ['Gymnastique Volontaire Aix-les-Bains, 24 Av. de Marlioz, 73100 Aix-les-Bains, France','Gymnase de Marlioz, 120 Chem. du Lycée, 73100 Aix-les-Bains, France',
                'Aix Maurienne Savoie Basket, Gymnase de Marlioz, 120 Chem. du Lycée, 73100 Aix-les-Bains, France'];
            $ListeLieuxB = ['Maurienne Savoie Basket, Chef Lieu, 73220 Val-d\'Arc, France',
                'Chef Lieu, 73220 Val-d\'Arc'];
            $endroit = $event->getLocation();
            $longueur = count($ListeLieuxA);

            for ($i=0; $i < $longueur; $i++) {
                if ($endroit == $ListeLieuxA[$i]){
                    $place = 'Aix les bains';
                }
            }

            $longueur = count($ListeLieuxB);
            for ($i=0; $i < $longueur; $i++) {
                if ($endroit == $ListeLieuxB[$i]){
                    $place = 'Aiguebelle';
                }
            }


            $newEvent = Event::updateOrCreate(
                ['id' => $event->getId()],
                [
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'location' => $event->getLocation(),
                    'place' => $place,
                    'start' => $start,
                    'end' => $end,
                    'isRecurring' => !is_null($event->getRecurringEventId()),
                ]
            );

            // Extraire et traiter les catégories (équipes) de la description
            $teamCategories = explode(',', $newEvent->description);
            $userIds = [];

            foreach ($teamCategories as $category) {
                $team = Team::where('category', trim($category))->first();
                if ($team) {
                    $teamUserIds = $team->users->pluck('id')->toArray();
                    $userIds = array_merge($userIds, $teamUserIds);
                }
            }

            $userIds = array_unique($userIds); // Enlever les doublons

            if (!empty($userIds)) {
                // Créer ou mettre à jour un groupe pour l'événement
                $group = Group::firstOrCreate(
                    ['name' => $newEvent->title . " Group", 'type' => 'group']
                );

                // Attacher les utilisateurs à ce groupe
                $group->users()->sync($userIds);
            }
        }
        return $event;
        //return response()->json(['success' => true, 'message' => 'Events updated/created successfully.']);

    }

    public function getCategories(Request $request): JsonResponse
    {
        // Configuration de l'accès à l'API Google Calendar
        $client = new Google_Client();
        $client->setAuthConfig(config_path('google/credentials.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);

        // Authentification avec une clé d'API
        $client->setDeveloperKey('AIzaSyCxxKnWhC3mcOalpB-FCWJoA9Kg9jSCnPs');

        // Création du service Google Calendar
        $service = new Google_Service_Calendar($client);

        // Récupération des événements
        $calendarId = 'charriersim@gmail.com';
        $optParams = [
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        // Créer un tableau associatif pour stocker les catégories par ID d'événement
        $categoriesById = [];

        // Parcourir chaque événement et extraire les catégories de sa description
        foreach ($events as $event) {
            // Récupérer l'identifiant de l'événement
            $eventId = $event->getId();

            // Extraire les catégories de la description de l'événement
            $categories = explode(',', $event->getDescription());

            // Stocker les catégories dans le tableau associatif en les liant à l'identifiant de l'événement
            $categoriesById[$eventId] = $categories;
        }

        // Retourner les catégories par ID d'événement au format JSON
        return response()->json([
            'categoriesById' => $categoriesById,
        ]);
    }

    public function getCategoriesById(Request $request, $eventId): JsonResponse
    {
        // Configuration de l'accès à l'API Google Calendar
        $client = new Google_Client();
        $client->setAuthConfig(config_path('google/credentials.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);

        // Authentification avec une clé d'API
        $client->setDeveloperKey('AIzaSyCxxKnWhC3mcOalpB-FCWJoA9Kg9jSCnPs');

        // Création du service Google Calendar
        $service = new Google_Service_Calendar($client);

        // Récupération de l'événement spécifié par son ID
        $event = $service->events->get('charriersim@gmail.com', $eventId);

        // Extraire les catégories de la description de l'événement
        $categories = explode(',', $event->getDescription());

        // Retourner les catégories au format JSON
        return response()->json([
            'eventId' => $eventId,
            'categories' => $categories,
        ]);
    }



    public function getEventsByCategory(Request $request, $categories): JsonResponse
    {
        $client = new Google_Client();
        $client->setAuthConfig(config_path('google/credentials.json'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setDeveloperKey('AIzaSyCxxKnWhC3mcOalpB-FCWJoA9Kg9jSCnPs');

        $service = new Google_Service_Calendar($client);
        $calendarId = 'charriersim@gmail.com';
        $optParams = [
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        $placeFilter = $request->get('place_filter', 'both');
        $domicilePlace = $request->get('domicile_place', 'both');

        $filteredEvents = [];
        foreach ($events as $event) {
            $description = $event->getDescription();
            foreach ($categories as $category) {
                if ($description && strpos($description, $category) !== false) {
                    $eventId = $event->getId();
                    $dbEvent = Event::where('id', $eventId)->first();

                    $includeEvent = false;
                    if ($dbEvent) {
                        if ($placeFilter === 'both') {
                            $includeEvent = true;
                        } elseif ($placeFilter === 'domicile' && $dbEvent->place !== null) {
                            if ($domicilePlace === 'both' || strpos(strtolower($dbEvent->place), strtolower($domicilePlace)) !== false) {
                                $includeEvent = true;
                            }
                        } elseif ($placeFilter === 'exterieur' && $dbEvent->place === null) {
                            $includeEvent = true;
                        }
                    }

                    if ($includeEvent) {
                        $newEvent = [
                            'id' => $event->getId(),
                            'title' => $event->getSummary(),
                            'description' => $event->getDescription(),
                            'location' => $event->getLocation(),
                            'place' => $dbEvent ? $dbEvent->place : null,
                            'start' => $event->getStart()->dateTime,
                            'end' => $event->getEnd()->dateTime,
                            'isRecurring' => $event->getRecurringEventId() ? 1 : 0
                        ];
                        $teamNames = explode(',', $description);
                        $colors = $this->fetchColorsForTeams($teamNames);
                        $filteredEvents[] = [
                            'event' => $newEvent,
                            'colors' => $colors
                        ];
                    }
                }
            }
        }

        return response()->json(['data' => $filteredEvents]);
    }



//    public function getEventsByCategory(Request $request, $categories): JsonResponse
//    {
//        // Configuration de l'accès à l'API Google Calendar
//        $client = new Google_Client();
//        $client->setAuthConfig(config_path('google/credentials.json'));
//        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
//
//        // Authentification avec une clé d'API
//        $client->setDeveloperKey('AIzaSyCxxKnWhC3mcOalpB-FCWJoA9Kg9jSCnPs');
//
//        // Création du service Google Calendar
//        $service = new Google_Service_Calendar($client);
//
//        // Récupération des événements
//        $calendarId = 'charriersim@gmail.com';
//        $optParams = [
//            'orderBy' => 'startTime',
//            'singleEvents' => true,
//            'timeMin' => date('c'),
//        ];
//
//        $results = $service->events->listEvents($calendarId, $optParams);
//        $events = $results->getItems();
//
//        // Filtrer les événements pour ceux qui contiennent la catégorie spécifiée dans leur description
//        $filteredEvents = [];
//        foreach ($events as $event) {
//            $description = $event->getDescription();
//            // Log pour voir ce que contient réellement description
//            // Log::info("Description: $description, Category: $category, Match: " . strpos($description, $category));
//            foreach ($categories as $category) {
//                if ($description && strpos($description, $category) !== false) {
//                    // Recherche de l'événement dans la base de données
//                    $dbEvent = Event::where('id', $event->getId())->first();
//
//                    $newEvent = [
//                        'id' => $event->getId(),
//                        'title' => $event->getSummary(),
//                        'description' => $event->getDescription(),
//                        'location' => $event->getLocation(),
//                        'place' => $dbEvent ? $dbEvent->place : null,
//                        'start' => $event->getStart()->dateTime,
//                        'end' => $event->getEnd()->dateTime,
//                        'isRecurring' => $event->getRecurringEventId() ? 1 : 0
//                    ];
//                    $teamNames = explode(',', $description);
//                    $colors = $this->fetchColorsForTeams($teamNames);
//                    $filteredEvents[] = [
//                        'event' => $newEvent,
//                        'colors' => $colors
//                    ];
//                }
//            }
//        }
//
//        // Retourner les événements filtrés au format JSON
//        return response()->json([
//            'data' => $filteredEvents,
//        ]);
//    }

    private function prepareEventData($event)
    {
        $startDateTime = $event->getStart()->dateTime;
        $endDateTime = $event->getEnd()->dateTime;

        $start = $startDateTime ? Carbon::parse($startDateTime)->format('Y-m-d H:i:s') : null;
        $end = $endDateTime ? Carbon::parse($endDateTime)->format('Y-m-d H:i:s') : null;

        return Event::updateOrCreate(
            ['id' => $event->getId()],
            [
                'title' => $event->getSummary(),
                'description' => $event->getDescription(),
                'location' => $event->getLocation(),
                'place' => $event->getPlace(),
                'start' => $start,
                'end' => $end,
                'isRecurring' => $event->getRecurringEventId() !== null ? 1 : 0,
            ]
        );
    }

    private function fetchColorsForTeams($teamNames)
    {
        $colors = [];
        foreach ($teamNames as $teamName) {
            $team = Team::where('name', trim($teamName))->first();
            $colors[] = $team ? $team->color : '#ccc'; // Utiliser une couleur par défaut si l'équipe n'est pas trouvée
        }
        return $colors;
    }


    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', [
            'event' => $event
        ]);
    }


}
