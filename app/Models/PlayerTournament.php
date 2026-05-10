<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTournament extends Model
{
    protected $fillable = [
        'player_id',
        'tournament_name',
        'tournament_date',
        'location',
        'medal',
        'weight_class',
        'position',
        'notes',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
