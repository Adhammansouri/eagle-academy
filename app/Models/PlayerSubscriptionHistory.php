<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerSubscriptionHistory extends Model
{
    public const TYPE_REGISTRATION = 'registration';

    public const TYPE_RENEWAL = 'renewal';

    protected $fillable = [
        'player_id',
        'type',
        'amount',
        'subscription_date',
        'expiration_date',
        'previous_subscription_date',
        'previous_expiration_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'subscription_date' => 'date',
            'expiration_date' => 'date',
            'previous_subscription_date' => 'date',
            'previous_expiration_date' => 'date',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            self::TYPE_REGISTRATION => 'تسجيل جديد',
            self::TYPE_RENEWAL => 'تجديد اشتراك',
            default => $this->type,
        };
    }
}
