<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
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
        }

        $events = $events->get();

        $categories = Team::all()->pluck('name'); // Exemple de récupération des noms de catégories
        return view('calendar', [
            'events' => $events,
            'categories' => $categories, // Assurez-vous de passer vos catégories à la vue
        ]);
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
