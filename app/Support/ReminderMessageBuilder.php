<?php

namespace App\Support;

use App\Models\Player;
use Carbon\Carbon;

class ReminderMessageBuilder
{
    public static function build(Player $player, int $daysRemaining): string
    {
        $expiration = Carbon::parse($player->expiration_date)->format('Y-m-d');
        $name = $player->name;
        $portalUrl = rtrim(config('app.url'), '/') . '/portal';
        $playerCode = $player->player_code ?? '';

        $portalLine = "\n\nللاستعلام عن حالة اللاعب من البورتال:\n{$portalUrl}\nكود اللاعب: {$playerCode}";

        if ($daysRemaining <= 0) {
            return "مرحباً {$name}، اشتراكك في أكاديمية النسر للملاكمة انتهى في {$expiration}. يرجى التجديد في أقرب وقت للاستمرار في التدريب." . $portalLine;
        }

        return "مرحباً {$name}، اشتراكك في أكاديمية النسر للملاكمة ينتهي في {$expiration} (باقي {$daysRemaining} يوم). يرجى التجديد في أقرب وقت." . $portalLine;
    }
}
