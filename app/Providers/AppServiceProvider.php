<?php

namespace App\Providers;

use App\Services\ExpiringSubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.sidebar-nav', function ($view) {
            $pendingRemindersCount = 0;

            $user = Auth::user();

            if ($user) {
                $pendingRemindersCount = app(ExpiringSubscriptionService::class)->pendingCount();
            }

            $view->with('pendingRemindersCount', $pendingRemindersCount);
        });
    }
}
