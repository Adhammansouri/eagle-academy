<?php

namespace App\Http\Controllers;

use App\Models\PlayerSubscriptionHistory;
use Illuminate\Http\Request;

class SubscriptionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PlayerSubscriptionHistory::query()
            ->with('player')
            ->latest('created_at');

        if ($search = $request->get('search')) {
            $query->whereHas('player', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('player_code', 'like', "%{$search}%");
            });
        }

        if ($type = $request->get('type')) {
            if (in_array($type, [
                PlayerSubscriptionHistory::TYPE_REGISTRATION,
                PlayerSubscriptionHistory::TYPE_RENEWAL,
            ], true)) {
                $query->where('type', $type);
            }
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $statsQuery = clone $query;

        $histories = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'registrations' => (clone $statsQuery)
                ->where('type', PlayerSubscriptionHistory::TYPE_REGISTRATION)
                ->count(),
            'renewals' => (clone $statsQuery)
                ->where('type', PlayerSubscriptionHistory::TYPE_RENEWAL)
                ->count(),
            'total_amount' => (float) (clone $statsQuery)->sum('amount'),
        ];

        return view('subscriptions.history', compact('histories', 'stats'));
    }
}
