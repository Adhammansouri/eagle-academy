<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionReminder extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_SENT = 'sent';

    public const STATUS_DISMISSED = 'dismissed';

    protected $fillable = [
        'player_id',
        'expiration_date',
        'days_before',
        'status',
        'sent_at',
        'sent_by',
        'channel',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'expiration_date' => 'date',
            'sent_at' => 'datetime',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function sentByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
