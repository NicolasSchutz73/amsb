<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupNotificationSetting; // Assurez-vous que le modèle existe et est correctement nommé

class GroupNotificationSettingController extends Controller
{
    public function toggleNotification(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'group_id' => 'required|integer',
            'user_id' => 'required|integer',
            'notif_status' => 'required|boolean',
        ]);

        $setting = GroupNotificationSetting::updateNotifications(
            $validatedData['group_id'],
            $validatedData['user_id'],
            $validatedData['status']
        );

        return response()->json([
            'message' => 'Notification setting updated successfully',
            'setting' => $setting,
        ]);
    }

    // Méthode pour récupérer le statut de notification actuel
    public function getNotificationStatus($groupId, $userId): \Illuminate\Http\JsonResponse
    {
        $setting = GroupNotificationSetting::where('group_id', $groupId)
            ->where('user_id', $userId)
            ->first(['notif_status']);

        if (!$setting) {
            return response()->json(['error' => 'Settings not found'], 404);
        }

        return response()->json($setting);
    }


    public function initializeSetting(Request $request): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user_id; // ou utilisez auth()->id() si l'utilisateur est authentifié
        $groupId = $request->group_id;

        // Appelle la méthode du modèle pour initialiser la configuration
        $setting = GroupNotificationSetting::initializeSetting($userId, $groupId);

        // Renvoie une réponse JSON
        return response()->json(['message' => 'Setting initialized', 'setting' => $setting]);
    }


    public function getNotificationSetting($groupId, $userId) {
        // Utilisez la méthode du modèle pour obtenir ou créer la configuration
        $setting = GroupNotificationSetting::getOrCreateSetting($userId, $groupId);

        return response()->json($setting);
    }


}
