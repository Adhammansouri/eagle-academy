<?php

namespace App\Console\Commands;

use App\Services\ExpiringSubscriptionService;
use Illuminate\Console\Command;

class ScanExpiringSubscriptions extends Command
{
    protected $signature = 'reminders:scan';

    protected $description = 'اكتشاف الاشتراكات القريبة من الانتهاء وتسجيل تنبيهات معلّقة';

    public function handle(ExpiringSubscriptionService $service): int
    {
        $created = $service->scanAndCreatePending();
        $total = $service->expiringPlayers()->count();

        $this->info("تم فحص {$total} لاعباً، وسجّل {$created} تنبيهاً جديداً.");

        return self::SUCCESS;
    }
}
