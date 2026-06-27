<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerEvaluation extends Model
{
    protected $fillable = [
        'player_id',
        'evaluation_date',
        'tech_score',
        'speed_score',
        'defense_score',
        'fitness_score',
        'discipline_score',
        'coach_notes',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function videos()
    {
        return $this->hasMany(EvaluationVideo::class, 'player_evaluation_id');
    }
}
