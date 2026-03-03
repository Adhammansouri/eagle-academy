<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Smart Filter Query
        $query = Player::query();

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by Source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Search by Name or ID
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('id', $searchTerm);
            });
        }
        
        // Filter by Status (Active vs Expired)
        if ($request->filled('status')) {
            $today = Carbon::today();
            if ($request->status == 'active') {
                $query->whereDate('expiration_date', '>=', $today);
            } elseif ($request->status == 'expired') {
                $query->whereDate('expiration_date', '<', $today);
            }
        }

        // Get filtered players for the table
        $filteredPlayers = $query->orderBy('id', 'desc')->get();

        // 2. Financial Metrics (based on filtered players)
        $totalRevenue = $query->sum('fee');
        
        // Detailed Financials
        $academyRevenue = (clone $query)->where('source', 'الاكاديميه')->sum('fee');
        $forceGymRevenue = (clone $query)->where('source', 'فورس جيم')->sum('fee');

        // 3. Growth Metrics (Subscriptions per month for the last 6 months)
        $growthData = [];
        $growthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::today()->startOfMonth()->subMonths($i);
            $monthEnd = clone $monthStart;
            $monthEnd->endOfMonth();
            
            $monthName = $monthStart->locale('ar')->translatedFormat('F'); // Arabic Month Name
            
            // Allow applying filters to the growth chart too, or keep it global
            $count = (clone $query)->whereBetween('subscription_date', [$monthStart, $monthEnd])->count();
            
            $growthLabels[] = $monthName;
            $growthData[] = $count;
        }

        return view('reports', compact(
            'filteredPlayers', 
            'totalRevenue', 
            'academyRevenue',
            'forceGymRevenue',
            'growthLabels', 
            'growthData'
        ));
    }
}
