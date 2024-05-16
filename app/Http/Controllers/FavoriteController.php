<?php

// app/Http/Controllers/FavoriteController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;

class FavoriteController extends Controller
{
    public function getUserFavorites()
    {
        $userId = Auth::id();
        $favoriteGroups = Auth::user()->favoriteGroups;

        return response()->json([
            'favorites' => $favoriteGroups,
        ]);
    }

    public function addFavorite(Request $request)
    {
        $user = Auth::user();
        $groupId = $request->input('group_id');

        if ($user->favoriteGroups()->where('group_id', $groupId)->exists()) {
            return response()->json(['message' => 'Group already in favorites'], 400);
        }

        $user->favoriteGroups()->attach($groupId);

        return response()->json(['message' => 'Group added to favorites']);
    }

    public function removeFavorite(Request $request)
    {
        $user = Auth::user();
        $groupId = $request->input('group_id');

        if (!$user->favoriteGroups()->where('group_id', $groupId)->exists()) {
            return response()->json(['message' => 'Group not in favorites'], 400);
        }

        $user->favoriteGroups()->detach($groupId);

        return response()->json(['message' => 'Group removed from favorites']);
    }
}
