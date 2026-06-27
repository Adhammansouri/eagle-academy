<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Services\ExpiringSubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function __construct(
        private readonly ExpiringSubscriptionService $expiringService
    ) {}

    public function index(): View
    {
        $items = $this->expiringService->buildReminderItems();
        $pendingCount = $items->where('status', 'pending')->count();
        $windowDays = ExpiringSubscriptionService::WINDOW_DAYS;

        return view('reminders.index', compact('items', 'pendingCount', 'windowDays'));
    }

    public function markSent(int $id): RedirectResponse
    {
        $player = Player::findOrFail($id);
        $this->expiringService->markSent($player, auth()->id());

        return redirect()
            ->route('reminders.index')
            ->with('success', 'تم تعليم التنبيه كمُرسل.');
    }

    public function dismiss(int $id): RedirectResponse
    {
        $player = Player::findOrFail($id);
        $this->expiringService->dismiss($player);

        return redirect()
            ->route('reminders.index')
            ->with('success', 'تم تجاهل التنبيه.');
    }
}
