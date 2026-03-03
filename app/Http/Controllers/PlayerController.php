<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $playersCount = Player::count();
        $newSubsCount = Player::whereMonth('subscription_date', date('m'))->count();
        
        // Calculate total revenue (sum of all fees)
        $totalRevenue = Player::sum('fee');

        // Calculate expiring soon (within 7 days)
        $sevenDaysFromNow = \Carbon\Carbon::now()->addDays(7)->endOfDay();
        $today = \Carbon\Carbon::now()->startOfDay();
        $expiringSoonCount = Player::whereBetween('expiration_date', [$today, $sevenDaysFromNow])->count();

        // Get recent activity (last 5 registrations)
        $recentPlayers = Player::orderBy('id', 'desc')->take(5)->get();
        
        $categories = [
            'kids' => Player::where('category', 'براعم')->count(),
            'youth' => Player::where('category', 'شباب')->count(),
        ];
        
        $sources = [
            'academy' => Player::where('source', 'الاكاديميه')->count(),
            'force_gym' => Player::where('source', 'فورس جيم')->count(),
        ];

        return view('dashboard', compact(
            'playersCount', 
            'newSubsCount', 
            'totalRevenue', 
            'expiringSoonCount', 
            'recentPlayers', 
            'categories', 
            'sources'
        ));
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_year' => 'required|integer',
            'subscription_date' => 'required|date',
            'expiration_date' => 'required|date',
            'fee' => 'required|numeric|min:0',
            'category' => 'nullable|string|in:براعم,شباب',
            'source' => 'required|in:الاكاديميه,فورس جيم',
        ]);
        $player = Player::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل اللاعب بنجاح ✔',
            'player' => $player
        ]);
    }
    public function list()
    {
        $players = Player::orderBy('id', 'desc')->get();
        return view('players', compact('players'));
    }
}
