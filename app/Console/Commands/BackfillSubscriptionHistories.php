<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\PlayerSubscriptionHistory;
use Illuminate\Console\Command;

class BackfillSubscriptionHistories extends Command
{
    protected $signature = 'subscriptions:backfill';

    protected $description = 'Create initial registration history records for existing players';

    public function handle(): int
    {
        $created = 0;

        Player::query()
            ->whereDoesntHave('subscriptionHistories')
            ->chunkById(100, function ($players) use (&$created) {
                foreach ($players as $player) {
                    $player->subscriptionHistories()->create([
                        'type' => PlayerSubscriptionHistory::TYPE_REGISTRATION,
                        'amount' => $player->fee ?? 0,
                        'subscription_date' => $player->subscription_date,
                        'expiration_date' => $player->expiration_date,
                        'previous_subscription_date' => null,
                        'previous_expiration_date' => null,
                        'created_at' => $player->subscription_date ?? $player->created_at,
                        'updated_at' => $player->subscription_date ?? $player->created_at,
                    ]);
                    $created++;
                }
            });

        $this->info("Created {$created} registration history record(s).");

        return self::SUCCESS;
    }
}
