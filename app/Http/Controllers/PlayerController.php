<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerEvaluation;
use App\Models\PlayerFight;
use App\Models\PlayerWeight;
use App\Models\PlayerTournament;
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
            'player_code' => 'nullable|string|max:255|unique:players,player_code',
            'phone_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'birth_year' => 'required|integer',
            'subscription_date' => 'required|date',
            'expiration_date' => 'required|date',
            'fee' => 'required|numeric|min:0',
            'category' => 'nullable|string|in:براعم,شباب',
            'source' => 'required|in:الاكاديميه,فورس جيم',
        ]);

        // Auto-generate player code if not provided
        if (empty($validated['player_code'])) {
            $latestPlayer = Player::latest('id')->first();
            $nextId = $latestPlayer ? $latestPlayer->id + 1 : 1;
            $validated['player_code'] = 'EA-' . (1000 + $nextId);
        }

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

    public function evaluate(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'evaluation_date' => 'required|date',
            'tech_score' => 'nullable|integer|min:0|max:5',
            'speed_score' => 'nullable|integer|min:0|max:5',
            'defense_score' => 'nullable|integer|min:0|max:5',
            'fitness_score' => 'nullable|integer|min:0|max:5',
            'discipline_score' => 'nullable|integer|min:0|max:5',
            'coach_notes' => 'nullable|string|max:1000',
        ]);

        // Insert into player_evaluations
        $player->evaluations()->create($validated);

        // Also update the main player record with the latest evaluation for quick access/sorting if needed
        $player->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم حفظ التقييم بنجاح!']);
        }

        return redirect()->back()->with('success', 'تم حفظ التقييم بنجاح!');
    }

    public function profile($id)
    {
        $player = Player::with(['evaluations', 'fights', 'weights', 'tournaments'])->findOrFail($id);
        return view('profile', compact('player'));
    }

    public function storeFight(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'fight_date' => 'required|date',
            'opponent_name' => 'required|string|max:255',
            'opponent_club' => 'nullable|string|max:255',
            'result' => 'required|in:win,loss,draw',
            'result_method' => 'nullable|in:points,ko,tko,rsc,walkover,dq',
            'rounds' => 'nullable|integer|min:1|max:12',
            'weight_class' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $player->fights()->create($validated);

        return response()->json(['success' => true, 'message' => 'تم إضافة النزال بنجاح!']);
    }

    public function storeWeight(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'recorded_date' => 'required|date',
            'weight_kg' => 'required|numeric|min:10|max:200',
            'notes' => 'nullable|string|max:1000',
        ]);

        $player->weights()->create($validated);

        return response()->json(['success' => true, 'message' => 'تم تسجيل الوزن بنجاح!']);
    }

    public function storeTournament(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'tournament_name' => 'required|string|max:255',
            'tournament_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'medal' => 'required|in:gold,silver,bronze,participant',
            'weight_class' => 'nullable|string|max:50',
            'position' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $player->tournaments()->create($validated);

        return response()->json(['success' => true, 'message' => 'تم إضافة البطولة بنجاح!']);
    }
}
