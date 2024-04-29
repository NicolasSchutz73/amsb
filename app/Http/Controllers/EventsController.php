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

    public function getEvents(Request $request): JsonResponse
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

            $newEvent = Event::updateOrCreate(
                ['id' => $event->getId()],
                [
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'location' => $event->getLocation(),
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
                Log::info('Recherche de l\'équipe avec la catégorie', ['category' => trim($category)]);
                if ($team) {
                    Log::info('Équipe trouvée', ['team' => $team->toArray()]);
                    $teamUserIds = $team->users->pluck('id')->toArray();
                    $userIds = array_merge($userIds, $teamUserIds);
                }
            }

            $userIds = array_unique($userIds); // Enlever les doublons
            Log::info('IDs utilisateur pour le groupe', ['user_ids' => $userIds]);

            if (!empty($userIds)) {
                // Créer ou mettre à jour un groupe pour l'événement
                $group = Group::firstOrCreate(
                    ['name' => $newEvent->title . " Group", 'type' => 'group']
                );

                // Attacher les utilisateurs à ce groupe
                $group->users()->sync($userIds);
                Log::info('Groupe créé et utilisateurs ajoutés', ['group_id' => $group->id, 'user_ids' => $userIds]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Events updated/created successfully.']);

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

    public function getEventsByCategory(Request $request, $category): JsonResponse
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

        $eventsData = [];

        foreach ($events as $event) {
            $startDateTime = $event->getStart()->dateTime;
            $endDateTime = $event->getEnd()->dateTime;

            $start = $startDateTime ? Carbon::parse($startDateTime)->format('Y-m-d H:i:s') : null;
            $end = $endDateTime ? Carbon::parse($endDateTime)->format('Y-m-d H:i:s') : null;

            $newEvent = Event::updateOrCreate(
                ['id' => $event->getId()],
                [
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'location' => $event->getLocation(),
                    'start' => $start,
                    'end' => $end,
                    'isRecurring' => $event->getRecurringEventId() !== null ? 1 : 0,
                ]
            );

            $teamCategories = explode(',', $newEvent->description);
            $userIds = [];
            $teamNames = explode(',', $event->getDescription());

            $colors = [];
            foreach ($teamNames as $teamName) {
                // Rechercher l'équipe par nom
                $team = Team::where('name', trim($teamName))->first();
                if ($team) {
                    // Ajouter la couleur de l'équipe à la liste des couleurs
                    $colors[] = $team->color;
                } else {
                    // Utiliser une couleur par défaut si l'équipe n'est pas trouvée
                    $colors[] = '#ccc';
                }
            }

            // Ajouter les couleurs récupérées à votre logique de traitement ou de réponse
            $eventsData[] = [
                'event' => $newEvent,
                'colors' => $colors  // Stockez les couleurs avec les données de l'événement
            ];

            if (!empty($userIds)) {
                $group = Group::firstOrCreate(
                    ['name' => $newEvent->title . " Group", 'type' => 'group']
                );
                $group->users()->sync($userIds);
            }
        }

        return response()->json(['success' => true, 'data' => $eventsData]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', [
            'event' => $event
        ]);
    }


}
