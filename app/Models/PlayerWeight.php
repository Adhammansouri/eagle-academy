<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerWeight extends Model
{
    protected $fillable = [
        'player_id',
        'recorded_date',
        'weight_kg',
        'notes',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
