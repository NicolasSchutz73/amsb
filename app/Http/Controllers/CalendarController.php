<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        // Log pour vérifier si l'utilisateur est récupéré correctement
        Log::info('User retrieved:', ['user' => $user]);

        // Vérifier si l'utilisateur est authentifié
        if ($user) {
            // Récupérer les équipes associées à l'utilisateur connecté
            $teams = $user->team; // Correction : appel de la méthode team()

            // Log pour vérifier si les équipes sont récupérées correctement
            Log::info('Teams retrieved:', ['teams' => $teams->toArray()]);

            // Vérifier si des équipes sont trouvées
            if ($teams->isNotEmpty()) {
                // Récupérer le nom de la première équipe
                $category = $teams->first()->name;

                // Log pour vérifier le nom de l'équipe sélectionnée
                Log::info('Selected category:', ['category' => $category]);

                // Construire l'URL avec le paramètre de catégorie
                $redirectUrl = '/calendar?category=' . urlencode($category);

                // Log pour vérifier l'URL de redirection
                Log::info('Redirect URL:', ['url' => $redirectUrl]);

                // Rediriger vers l'URL du calendrier de l'équipe
                return redirect($redirectUrl);
            }
        }

        // Si aucune équipe n'est trouvée pour l'utilisateur ou s'il n'est pas connecté,
        // affichez simplement le calendrier avec toutes les catégories
        $events = Event::all();
        $categories = Team::all()->pluck('name');

        // Log pour vérifier si les événements et les catégories sont récupérés correctement
        Log::info('Events:', ['events' => $events->toArray()]);
        Log::info('Categories:', ['categories' => $categories->toArray()]);

        return view('calendar', [
            'events' => $events,
            'categories' => $categories,
        ]);
    }




}
