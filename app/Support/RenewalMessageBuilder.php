<?php

namespace App\Support;

use App\Models\Player;

class RenewalMessageBuilder
{
    public static function build(Player $player): string
    {
        $name = $player->name;
        $subscriptionDate = $player->subscription_date;
        $expirationDate = $player->expiration_date;
        $portalUrl = rtrim(config('app.url'), '/') . '/portal';
        $playerCode = $player->player_code ?? '';

        return "مرحباً {$name}، تم تجديد اشتراكك في أكاديمية النسر للملاكمة بنجاح ✅\n\n"
            . "بداية الاشتراك: {$subscriptionDate}\n"
            . "انتهاء الاشتراك: {$expirationDate}\n\n"
            . "للاستعلام عن حالة اللاعب من البورتال:\n"
            . "{$portalUrl}\n"
            . "كود اللاعب: {$playerCode}\n\n"
            . "نتمنى لكم تدريبات موفقة! 🥊";
    }
}
