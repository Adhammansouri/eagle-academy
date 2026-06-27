<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationVideo extends Model
{
    protected $fillable = [
        'player_evaluation_id',
        'player_id',
        'video_path',
        'original_name',
        'file_size',
        'duration_seconds',
    ];

    public function evaluation()
    {
        return $this->belongsTo(PlayerEvaluation::class, 'player_evaluation_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
