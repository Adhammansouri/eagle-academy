<?php

namespace App\Services;

use App\Models\Player;
use App\Models\SubscriptionReminder;
use App\Support\PhoneHelper;
use App\Support\ReminderMessageBuilder;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExpiringSubscriptionService
{
    public const WINDOW_DAYS = 7;

    public function expiringPlayers(): Collection
    {
        $today = Carbon::today();
        $end = Carbon::today()->addDays(self::WINDOW_DAYS);

        return Player::query()
            ->whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->whereDate('expiration_date', '>=', $today)
            ->whereDate('expiration_date', '<=', $end)
            ->orderBy('expiration_date')
            ->get();
    }

    public function buildReminderItems(): Collection
    {
        $today = Carbon::today();
        $players = $this->expiringPlayers();

        if ($players->isEmpty()) {
            return collect();
        }

        $reminders = SubscriptionReminder::query()
            ->whereIn('player_id', $players->pluck('id'))
            ->get()
            ->keyBy(fn (SubscriptionReminder $r) => $this->reminderKey($r->player_id, $r->expiration_date));

        return $players->map(function (Player $player) use ($today, $reminders) {
            $expiration = Carbon::parse($player->expiration_date)->startOfDay();
            $daysRemaining = (int) $today->diffInDays($expiration, false);
            $message = ReminderMessageBuilder::build($player, $daysRemaining);
            $key = $this->reminderKey($player->id, $expiration);
            $reminder = $reminders->get($key);
            $status = $reminder?->status ?? SubscriptionReminder::STATUS_PENDING;

            return [
                'player_id' => $player->id,
                'player_name' => $player->name,
                'player_code' => $player->player_code,
                'phone_number' => $player->phone_number,
                'expiration_date' => $expiration->format('Y-m-d'),
                'expiration_date_formatted' => $expiration->format('d/m/Y'),
                'days_remaining' => $daysRemaining,
                'message' => $message,
                'whatsapp_url' => PhoneHelper::whatsAppUrl($player->phone_number, $message),
                'status' => $status,
                'status_label' => $this->statusLabel($status),
                'reminder_id' => $reminder?->id,
            ];
        })->filter(fn (array $item) => $item['status'] !== SubscriptionReminder::STATUS_DISMISSED);
    }

    public function pendingCount(): int
    {
        return $this->buildReminderItems()
            ->where('status', SubscriptionReminder::STATUS_PENDING)
            ->count();
    }

    public function scanAndCreatePending(): int
    {
        $today = Carbon::today();
        $created = 0;

        foreach ($this->expiringPlayers() as $player) {
            $expiration = Carbon::parse($player->expiration_date)->startOfDay();
            $daysRemaining = (int) $today->diffInDays($expiration, false);
            $message = ReminderMessageBuilder::build($player, $daysRemaining);

            $reminder = SubscriptionReminder::query()->firstOrNew([
                'player_id' => $player->id,
                'expiration_date' => $expiration->toDateString(),
            ]);

            if (! $reminder->exists) {
                $reminder->status = SubscriptionReminder::STATUS_PENDING;
                $created++;
            } elseif ($reminder->status === SubscriptionReminder::STATUS_DISMISSED) {
                continue;
            }

            $reminder->days_before = max(0, $daysRemaining);
            $reminder->channel = 'whatsapp';
            $reminder->message = $message;

            if ($reminder->status !== SubscriptionReminder::STATUS_SENT) {
                $reminder->status = SubscriptionReminder::STATUS_PENDING;
            }

            $reminder->save();
        }

        return $created;
    }

    public function markSent(Player $player, ?int $userId = null): SubscriptionReminder
    {
        $today = Carbon::today();
        $expiration = Carbon::parse($player->expiration_date)->startOfDay();
        $daysRemaining = (int) $today->diffInDays($expiration, false);
        $message = ReminderMessageBuilder::build($player, $daysRemaining);

        return SubscriptionReminder::updateOrCreate(
            [
                'player_id' => $player->id,
                'expiration_date' => $expiration->toDateString(),
            ],
            [
                'days_before' => max(0, $daysRemaining),
                'status' => SubscriptionReminder::STATUS_SENT,
                'sent_at' => now(),
                'sent_by' => $userId,
                'channel' => 'whatsapp',
                'message' => $message,
            ]
        );
    }

    public function dismiss(Player $player): SubscriptionReminder
    {
        $expiration = Carbon::parse($player->expiration_date)->startOfDay();
        $today = Carbon::today();
        $daysRemaining = (int) $today->diffInDays($expiration, false);

        return SubscriptionReminder::updateOrCreate(
            [
                'player_id' => $player->id,
                'expiration_date' => $expiration->toDateString(),
            ],
            [
                'days_before' => max(0, $daysRemaining),
                'status' => SubscriptionReminder::STATUS_DISMISSED,
                'channel' => 'whatsapp',
            ]
        );
    }

    private function reminderKey(int $playerId, $expirationDate): string
    {
        $date = $expirationDate instanceof Carbon
            ? $expirationDate->toDateString()
            : Carbon::parse($expirationDate)->toDateString();

        return $playerId . '_' . $date;
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            SubscriptionReminder::STATUS_SENT => 'تم الإرسال',
            SubscriptionReminder::STATUS_DISMISSED => 'تم التجاهل',
            default => 'معلق',
        };
    }
}
