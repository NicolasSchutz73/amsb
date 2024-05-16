<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'color'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')->withTimestamps();
    }

    public function coach()
    {
        return $this->users()->whereHas('roles', function ($query) {
            $query->where('name', 'coach');
        });
    }

    public static function getAllCategories()
    {
        return self::pluck('name')->toArray();
    }
}
