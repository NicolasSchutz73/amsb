<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupNotificationSetting extends Model
{
    use HasFactory;

    // Nom de la table si différent du nom par défaut
    protected $table = 'group_notif_settings';

    // Définition des attributs qui sont mass assignable
    protected $fillable = ['group_id', 'user_id', 'notif_status'];

    /**
     * Relation avec le modèle User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le modèle Group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public static function initializeSetting($userId, $groupId)
    {
        $setting = self::firstOrCreate(
            [
                'user_id' => $userId,
                'group_id' => $groupId
            ],
            [
                'notif_status' => 0
            ]
        );

        return $setting;
    }

    public static function getOrCreateSetting($userId, $groupId)
    {
        // Tentez de récupérer le paramètre existant, sinon créez-en un nouveau
        return self::firstOrCreate(
            ['user_id' => $userId, 'group_id' => $groupId],
            ['notif_status' => true] // Valeur par défaut pour les nouvelles entrées
        );
    }

    public static function updateNotifications($groupId, $userId, $status){
        if($status) {
            $setting = self::firstOrCreate([
                'group_id' => $groupId,
                'user_id' => $userId,
            ]);

            $setting->notif_status = true;
            $setting->save();

            return $setting;
        }else{
            $setting = self::where('group_id', $groupId)
                ->where('user_id', $userId)
                ->first();

            if ($setting) {
                $setting->notif_status = false;
                $setting->save();
            }

            return $setting;
        }
    }



}
