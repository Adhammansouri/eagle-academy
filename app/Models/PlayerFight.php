<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerFight extends Model
{
    protected $fillable = [
        'player_id',
        'fight_date',
        'opponent_name',
        'opponent_club',
        'result',
        'result_method',
        'rounds',
        'weight_class',
        'notes',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
