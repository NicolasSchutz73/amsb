<?php

namespace App\Http\Controllers;

use App\Events\GroupCreated;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Group;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TeamController extends Controller
{

    /**
     * Constructeur de la classe UserController.
     * Applique les middlewares d'authentification et de permissions.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-team|edit-team|delete-team', ['only' => ['index','show']]);
        $this->middleware('permission:create-team', ['only' => ['create','store']]);
        $this->middleware('permission:edit-team', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-team', ['only' => ['destroy']]);
    }

    /**
     * Affiche la liste des équipes.
     * @return View
     */
    public function index(): View
    {
        // Passer les équipes paginées à la vue
        return view('teams.index', [
            'teams' => Team::orderBy('id')->paginate(8)
        ]);
    }

    /**
     * Affiche le formulaire de création d'une nouvelle équipe.
     * @return View
     */
    public function create(): View
    {
        // Récupère tous les utilisateurs disponibles
        $allUsers = User::all();

        // Instancier un objet Team (vide) pour accéder aux noms des champs
        $team = new Team;

        // Passer les champs du modèle à la vue
        return view('teams.create', compact('team', 'allUsers'));
    }

    /**
     * Stocke une nouvelle équipe dans la base de données.
     * @param StoreTeamRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTeamRequest $request): RedirectResponse
    {
        // Valider les données du formulaire à l'aide du StoreTeamRequest
        $validatedData = $request->validated();

        // Créer une nouvelle équipe avec les données validées
        $team = Team::create([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
            // Ajoute d'autres propriétés si nécessaire
        ]);

        Log::info('Équipe créée : ', ['team_id' => $team->id, 'team_name' => $team->name]);

        // Attacher les utilisateurs à l'équipe
        if (isset($validatedData['add_users'])) {
            $team->users()->attach($validatedData['add_users']);
            Log::info('Utilisateurs ajoutés à l\'équipe : ', ['team_id' => $team->id, 'users' => $validatedData['add_users']]);
        }

        // Créer un groupe associé à l'équipe nouvellement créée
        $group = new Group();
        $group->name = $team->name . " Group"; // Nomme le groupe basé sur le nom de l'équipe
        $group->type = 'group'; // Utilise un type personnalisé comme 'team' pour identifier les groupes d'équipes
        $group->save();

        Log::info('Groupe créé : ', ['group_id' => $group->id, 'group_name' => $group->name]);

        // Attacher les utilisateurs/membres au groupe
        $userIds = $validatedData['add_users'] ?? [];
        $group->users()->sync($userIds);

        Log::info('Utilisateurs ajoutés au groupe : ', ['group_id' => $group->id, 'users' => $userIds]);

        // Déclencher l'événement de création de groupe si tu souhaites notifier les utilisateurs ou effectuer une action supplémentaire
        event(new GroupCreated($group));
        Log::info('Événement GroupCreated déclenché pour le groupe : ', ['group_id' => $group->id]);

        // Rediriger vers la page de la liste des équipes avec un message
        return redirect()->route('teams.index')->with('success', 'Équipe et groupe de discussion associé créés avec succès.');
    }

    /**
     * Affiche les détails de l'équipe spécifiée.
     * @param Team $team
     * @return View
     */
    public function show(Team $team): View
    {
        // Charger les utilisateurs liés à cette équipe
        $users = $team->users;

        // Charger les entraineurs liés à cette équipe
        $coaches = $team->users()->whereHas('roles', function ($query) {
            $query->where('name', 'coach');
        })->get();

        return view('teams.show', [
            'team' => $team,
            'users' => $users,
            'coaches' => $coaches,
        ]);
    }

    /**
     * Affiche le formulaire d'édition de l'équipe spécifié.
     * @param Team $team
     * @return View
     */
    public function edit(Team $team): View
    {
        $allUsers = User::all();

        return view('teams.edit', [
            'team' => $team,
            'allUsers' => $allUsers,
        ]);
    }

    /**
     * Met à jour l'équipe spécifié en base de données.
     * @param UpdateTeamRequest $request
     * @param Team $team
     * @return RedirectResponse
    */
    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $validatedData = $request->validated();

        // Met à jour les propriétés de l'équipe
        $team->update([
            'name' => $validatedData['name'],
            'category' => $validatedData['category'],
        ]);

        // Ajoute les utilisateurs à l'équipe
        if (isset($validatedData['add_users'])) {
            $team->users()->attach($validatedData['add_users']);
        }

        // Supprime les utilisateurs de l'équipe
        if (isset($validatedData['remove_users'])) {
            $team->users()->detach($validatedData['remove_users']);
        }

        // Redirige vers la page de détails de l'équipe
        return redirect()->route('teams.show', $team->id)->with('success', 'L\'équipe a été mise à jour avec succès.');
    }

    /**
     * Supprime l'équipe spécifiée de la base de données.
     * @param Team $team
     * @return RedirectResponse
     */
    public function destroy(Team $team):RedirectResponse
    {
        // Supprime l'équipe de la base de données
        $team->delete();

        return redirect()->route('teams.index');
    }

    public function showUserTeams()
    {
        $user = auth()->user();
        $teams = $user->team()->get(); // Récupérer toutes les équipes associées à l'utilisateur

        $teamDetails = []; // Array pour stocker les détails de chaque équipe

        foreach ($teams as $team) {
            // Charger les utilisateurs liés à cette équipe
            $users = $team->users;

            // Charger les entraîneurs liés à cette équipe
            $coaches = $team->users()->whereHas('roles', function ($query) {
                $query->where('name', 'coach');
            })->get();

            // Stocker les détails de l'équipe dans le tableau
            $teamDetails[$team->id] = [
                'team' => $team,
                'users' => $users,
                'coaches' => $coaches,
            ];
        }

        return view('user_teams.show', ['teamDetails' => $teamDetails]);
    }


}
