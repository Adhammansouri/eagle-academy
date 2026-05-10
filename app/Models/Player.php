<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'player_code',
        'name',
        'birth_year',
        'subscription_date',
        'expiration_date',
        'phone_number',
        'fee',
        'category',
        'source',
        'speed_score',
        'fitness_score',
        'tactical_score',
        'tech_score',
        'defense_score',
        'discipline_score',
        'evaluation_date',
        'coach_notes',
    ];

    public function evaluations()
    {
        return $this->hasMany(PlayerEvaluation::class)->orderBy('evaluation_date', 'desc');
    }

    public function fights()
    {
        return $this->hasMany(PlayerFight::class)->orderBy('fight_date', 'desc');
    }

    public function weights()
    {
        return $this->hasMany(PlayerWeight::class)->orderBy('recorded_date', 'desc');
    }

    public function tournaments()
    {
        return $this->hasMany(PlayerTournament::class)->orderBy('tournament_date', 'desc');
    }
}
