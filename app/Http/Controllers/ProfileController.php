<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire de profil de l'utilisateur.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Mettre à jour les informations de profil de l'utilisateur.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Mise à jour de la photo de profil sur le serveur SFTP distant (via le port FTP standard)
        if ($request->hasFile('profile_photo')) {
            $path = "profile/" . $request->user()->id . '.jpg';

            // Gestion des erreurs de téléchargement
            $fileContent = file_get_contents($request->file('profile_photo')->getRealPath());
            try {
                if (Storage::disk('ftp')->put($path, $fileContent)) {
                    // Téléchargement réussi
                    Storage::disk('ftp')->setVisibility($path, 'public');
                    $user->profile_photo_path = $path;
                } else {
                    // Échec du téléchargement
                    dd('Erreur de téléchargement.');
                }
            } catch (\Exception $e) {
                dd('Exception : ' . $e->getMessage());
            }
        }

        if ($request->hasFile('document')) {
            $path = "documents/" . $request->user()->id . '.pdf';

            // Gestion des erreurs de téléchargement
            $fileContent = file_get_contents($request->file('document')->getRealPath());

            try {
                if (Storage::disk('ftp')->put($path, $fileContent)) {
                    // Téléchargement réussi
                    Storage::disk('ftp')->setVisibility($path, 'public');
                    // Vous pouvez stocker le chemin du document dans la base de données si nécessaire
                    $user->document_path = $path;
                } else {
                    // Échec du téléchargement
                    dd('Erreur de téléchargement.');
                }
            } catch (\Exception $e) {
                dd('Exception : ' . $e->getMessage());
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Supprimer le compte de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Obtenir le nom de l'utilisateur en format JSON.
     */
    public function getName(Request $request)
    {
        return response()->json(['name' => $request->user()]);
    }


    public function uploadPhotos(Request $request)
    {
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();
        $path = "picture/{$user->id}";

        // Créez le dossier si n'existe pas
        if (!Storage::disk('ftp')->exists($path)) {
            Storage::disk('ftp')->makeDirectory($path);
        }

        $uploadedFiles = $request->file('photos');
        foreach ($uploadedFiles as $file) {
            $filePath = "{$path}/{$file->getClientOriginalName()}";

            // Enregistrez le fichier sur le serveur FTP
            try {
                if (Storage::disk('ftp')->put($filePath, file_get_contents($file->getRealPath()))) {
                    // Téléchargement réussi
                    Storage::disk('ftp')->setVisibility($filePath, 'public');
                } else {
                    return back()->with('error', 'Erreur de téléchargement.');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Exception : ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Photos téléchargées avec succès.');
    }
}
