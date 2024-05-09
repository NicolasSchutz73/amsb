<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function getUserTeam()
    {
        // Authentification de l'utilisateur
        $user = auth()->user();

        // Récupération de l'équipe de l'utilisateur
        $userTeam = $user->team()->first(); // Supposant qu'un utilisateur peut appartenir à une seule équipe

        // Vérification du nombre d'équipes de l'utilisateur
        $numberOfTeams = $user->team()->count();

        if ($userTeam) {
            if ($numberOfTeams === 1) {
                // L'utilisateur a une seule équipe, retourner l'ID de l'équipe
                return ['team_id' => $userTeam->id];
            } else {
                // L'utilisateur a plus d'une équipe, retourner une erreur
                return ['error' => 'L\'utilisateur a plus d\'une équipe.'];
            }
        } else {
            // L'utilisateur n'est pas associé à une équipe, retourner une erreur
            return ['error' => 'Aucune équipe associée à cet utilisateur.'];
        }
    }

    public function getTeamName($teamId)
    {
        // Recherche de l'équipe par son ID
        $team = Team::find($teamId);

        if ($team) {
            // Si l'équipe est trouvée, récupérez son nom
            $teamName = $team->name;
            return ['team_name' => $teamName];
        } else {
            // Si l'équipe n'est pas trouvée, retournez une erreur
            return ['error' => 'L\'équipe avec l\'ID spécifié n\'existe pas.'];
        }
    }



    public function show(Request $request)
    {

        $events = Event::all(); // Récupère tous les événements pour simplifier

        // Récupérer les catégories depuis un modèle Team ou autre logique
        $categories = Team::all()->pluck('name'); // Exemple de récupération des noms de catégories

        return view('calendar', [
            'events' => $events,
            'categories' => $categories,
        ]);
    }

    public function index(Request $request)
    {
        $filtre = false;
        $valable = false;

        // Authentification de l'utilisateur et récupération de l'équipe de l'utilisateur
        $user = auth()->user();
        $userTeam = $user->team()->first();
        $teamData = $this->getUserTeam();

        // Récupération des noms des équipes sélectionnées via des checkboxes
        $teamNames = $request->input('teams', []);

        // Récupération de toutes les catégories pour les options du formulaire
        $categories = Team::all()->pluck('name');

        // Initialisation de la requête d'événements
        $events = Event::query();

        // Filtrer les événements si des noms d'équipe sont sélectionnés
        if (!empty($teamNames)) {
            $filtre = true;
            $events = $events->where(function ($query) use ($teamNames) {
                foreach ($teamNames as $teamName) {
                    // Utilisation de LIKE pour isoler mieux les mots en cherchant des correspondances exactes dans la description
                    $team = Team::where('name', $teamName)->first();
                    if ($team) {
                        $query->orWhere('description', 'like', "%{$team->name}%");
                    }
                }
            });
        }

        $events = $events->get();

//        dd($events);

        if ($teamData == ['team_id' => $userTeam->id]) {
            $teamId = $teamData['team_id'];
            $teamNameData = $this->getTeamName($teamId);
            $teamName = $teamNameData['team_name'];
            $valable = true;

            return view('calendar', [
                'events' => $events,
                'categories' => $categories,
                'teamName' => $teamName,
                'filtre' => $filtre,
                'valable' => $valable,
                'color' => '#ccc'
            ]);
        } else {
            return view('calendar', [
                'events' => $events,
                'categories' => $categories,
                'filtre' => $filtre,
                'valable' => $valable,
                'color' => '#ccc'
            ]);
        }
    }



//    public function index(Request $request)
//    {
//        $filtre = false;
//        $valable = false;
//        $user = auth()->user();
//        $userTeam = $user->team()->first();
//        $teamData = $this->getUserTeam();
//        $teamNames = $request->input('teams', []);
//        $categories = Team::all()->pluck('name');
//
//        $events = Event::select('events.*', 'teams.color as teamColor')
//            ->leftJoin('teams', 'events.descritpion', '=', 'teams.name');
//
//        if (!empty($teamNames)) {
//            $filtre = true;
//            $events = $events->whereIn('teams.name', $teamNames);
//        }
//
//        $events = $events->get();
//
//        if ($teamData == ['team_id' => $userTeam->id]) {
//            $teamId = $teamData['team_id'];
//            $teamNameData = $this->getTeamName($teamId);
//            $teamName = $teamNameData['team_name'];
//
//            $valable = true;
//
//            return view('calendar', [
//                'events' => $events,
//                'categories' => $categories,
//                'teamName' => $teamName,
//                'filtre' => $filtre,
//                'valable' => $valable
//            ]);
//        } else {
//            return view('calendar', [
//                'events' => $events,
//                'categories' => $categories,
//                'filtre' => $filtre,
//                'valable' => $valable
//            ]);
//        }
//    }


    private function fetchColorsForTeams($teamNames)
    {
        $colors = [];
        foreach ($teamNames as $teamName) {
            $team = Team::where('name', trim($teamName))->first();
            $colors[] = $team ? $team->color : '#ccc'; // Utiliser une couleur par défaut si l'équipe n'est pas trouvée
        }
        return $colors;
    }





    public function getCategoriesByName($name)
    {
        // Récupérer une équipe en fonction de son nom
        $team = Team::where('name', $name)->first();

        if ($team) {
            // Si une équipe est trouvée, vous pouvez récupérer sa catégorie
            return $team->category;
        } else {
            // Si aucune équipe n'est trouvée avec ce nom, vous pouvez retourner une valeur par défaut ou un message d'erreur
            return "Aucune équipe trouvée avec le nom $name";
        }
    }


}
