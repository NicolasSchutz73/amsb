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

        $category = $request->input('category');

        if ($category) {
            $team = Team::where('name', $category)->first();
            if ($team) {
                $category = $team->category;
            }
        }

        $events = Event::query();

        // Filtrer les événements si une catégorie est sélectionnée
        if ($category) {
            $events = $events->where('description', 'like', "%$category%");
            $filtre = true;
        }

        $events = $events->get();

        $categories = Team::all()->pluck('name'); // Exemple de récupération des noms de catégories

        $teamData = $this->getUserTeam();

        // Authentification de l'utilisateur
        $user = auth()->user();
        // Récupération de l'équipe de l'utilisateur
        $userTeam = $user->team()->first();

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
                'valable' => $valable
            ]);
        }else{
            return view('calendar', [
                'events' => $events,
                'categories' => $categories,
                'filtre' => $filtre,
                'valable' => $valable
            ]);
        }
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
