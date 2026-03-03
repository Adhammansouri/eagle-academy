<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'name',
        'birth_year',
        'subscription_date',
        'expiration_date',
        'fee',
        'category',
        'source',
    ];
}
