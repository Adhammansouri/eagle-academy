<?php

namespace App\Http\Controllers;

use App\Models\EvaluationVideo;
use App\Models\Player;
use App\Models\PlayerEvaluation;
use App\Models\PlayerFight;
use App\Models\PlayerSubscriptionHistory;
use App\Models\PlayerWeight;
use App\Models\PlayerTournament;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    public function index()
    {
        $playersCount = Player::count();
        $newSubsCount = Player::whereMonth('subscription_date', date('m'))->count();
        
        // Calculate total revenue (sum of all fees)
        $totalRevenue = Player::sum('fee');

        // Calculate expiring soon (within 7 days)
        $sevenDaysFromNow = Carbon::now()->addDays(7)->endOfDay();
        $today = Carbon::now()->startOfDay();
        $expiringSoonCount = Player::whereBetween('expiration_date', [$today, $sevenDaysFromNow])->count();

        // Calculate expired subscriptions
        $expiredCount = Player::where('expiration_date', '<', $today)->count();

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
            'expiredCount', 
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

        $player = DB::transaction(function () use ($validated) {
            $player = Player::create($validated);

            $player->subscriptionHistories()->create([
                'type' => PlayerSubscriptionHistory::TYPE_REGISTRATION,
                'amount' => $validated['fee'],
                'subscription_date' => $validated['subscription_date'],
                'expiration_date' => $validated['expiration_date'],
                'previous_subscription_date' => null,
                'previous_expiration_date' => null,
            ]);

            return $player;
        });

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل اللاعب بنجاح ✔',
            'player' => $player
        ]);
    }
    public function heroesWall(Request $request)
    {
        $skillLabels = [
            ['key' => 'tech_score', 'name' => 'فني'],
            ['key' => 'speed_score', 'name' => 'سرعة'],
            ['key' => 'defense_score', 'name' => 'دفاع'],
            ['key' => 'fitness_score', 'name' => 'لياقة'],
            ['key' => 'discipline_score', 'name' => 'انضباط'],
        ];

        $avgExpression = '(COALESCE(tech_score,0) + COALESCE(speed_score,0) + COALESCE(defense_score,0) + COALESCE(fitness_score,0) + COALESCE(discipline_score,0)) / 5.0';

        $categories = Player::whereNotNull('tech_score')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $activeCategory = $request->get('category', 'all');

        $query = Player::whereNotNull('tech_score')
            ->selectRaw("*, {$avgExpression} as avg_score");

        if ($activeCategory !== 'all' && $activeCategory !== null && $activeCategory !== '') {
            $query->where('category', $activeCategory);
        }

        $players = $query->orderByDesc('avg_score')->get();

        $evaluatedCount = $players->count();
        $academyAvg = $evaluatedCount > 0 ? round((float) $players->avg('avg_score'), 1) : 0;
        $topPlayer = $players->first();

        $dimensionAverages = [
            'labels' => array_column($skillLabels, 'name'),
            'values' => $evaluatedCount > 0
                ? [
                    round((float) $players->avg('tech_score'), 1),
                    round((float) $players->avg('speed_score'), 1),
                    round((float) $players->avg('defense_score'), 1),
                    round((float) $players->avg('fitness_score'), 1),
                    round((float) $players->avg('discipline_score'), 1),
                ]
                : [0, 0, 0, 0, 0],
        ];

        $top3 = $players->take(3);
        $podiumOrder = [];
        if ($top3->count() >= 2) {
            $podiumOrder[] = 1;
        }
        if ($top3->count() >= 1) {
            $podiumOrder[] = 0;
        }
        if ($top3->count() >= 3) {
            $podiumOrder[] = 2;
        }

        $medalEmojis = ['🥇', '🥈', '🥉'];
        $medalClasses = ['hw-pod--1', 'hw-pod--2', 'hw-pod--3'];

        return view('heroes-wall', compact(
            'players',
            'categories',
            'activeCategory',
            'evaluatedCount',
            'academyAvg',
            'topPlayer',
            'dimensionAverages',
            'skillLabels',
            'top3',
            'podiumOrder',
            'medalEmojis',
            'medalClasses'
        ));
    }

    public function list()
    {
        $players = Player::orderBy('id', 'desc')->get();
        return view('players', compact('players'));
    }

    public function expiredSubscriptions()
    {
        $today = Carbon::now()->startOfDay();
        $players = Player::where('expiration_date', '<', $today)
            ->orderBy('expiration_date', 'asc')
            ->get();

        return view('subscriptions.expired', compact('players'));
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
            'videos' => 'nullable|array|max:3',
            'videos.*' => 'file|mimetypes:video/mp4,video/quicktime,video/webm,video/x-msvideo|max:51200',
        ]);

        // Check monthly video limit (3 videos per evaluation month)
        $evalDate = Carbon::parse($validated['evaluation_date']);
        $monthStart = $evalDate->copy()->startOfMonth();
        $monthEnd = $evalDate->copy()->endOfMonth();

        $existingVideoCount = EvaluationVideo::where('player_id', $player->id)
            ->whereHas('evaluation', function ($q) use ($monthStart, $monthEnd) {
                $q->whereBetween('evaluation_date', [$monthStart, $monthEnd]);
            })
            ->count();

        $newVideoCount = $request->hasFile('videos') ? count($request->file('videos')) : 0;

        if ($existingVideoCount + $newVideoCount > 3) {
            $remaining = max(0, 3 - $existingVideoCount);
            return response()->json([
                'success' => false,
                'message' => "تم تجاوز الحد الأقصى للفيديوهات (3 فيديوهات لكل شهر). المتبقي: {$remaining} فيديو.",
            ], 422);
        }

        // Insert into player_evaluations
        $evaluation = $player->evaluations()->create($validated);

        // Handle video uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $path = $video->store("evaluation-videos/{$player->id}", 'public');
                $evaluation->videos()->create([
                    'player_id' => $player->id,
                    'video_path' => $path,
                    'original_name' => $video->getClientOriginalName(),
                    'file_size' => $video->getSize(),
                ]);
            }
        }

        // Also update the main player record with the latest evaluation for quick access/sorting if needed
        $player->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم حفظ التقييم بنجاح!']);
        }

        return redirect()->back()->with('success', 'تم حفظ التقييم بنجاح!');
    }

    public function renew(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'subscription_date' => 'required|date',
            'expiration_date' => 'required|date|after:subscription_date',
            'renewal_fee' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($player, $validated) {
            $previousSubscriptionDate = $player->subscription_date;
            $previousExpirationDate = $player->expiration_date;

            $player->subscription_date = $validated['subscription_date'];
            $player->expiration_date = $validated['expiration_date'];
            $player->fee = (float) $player->fee + (float) $validated['renewal_fee'];
            $player->save();

            $player->subscriptionHistories()->create([
                'type' => PlayerSubscriptionHistory::TYPE_RENEWAL,
                'amount' => $validated['renewal_fee'],
                'subscription_date' => $validated['subscription_date'],
                'expiration_date' => $validated['expiration_date'],
                'previous_subscription_date' => $previousSubscriptionDate,
                'previous_expiration_date' => $previousExpirationDate,
            ]);
        });

        $player->refresh();

        $today = \Carbon\Carbon::now()->startOfDay();
        $expirationDate = \Carbon\Carbon::parse($player->expiration_date)->startOfDay();
        $daysRemaining = $today->diffInDays($expirationDate, false);

        return response()->json([
            'success' => true,
            'message' => 'تم تجديد الاشتراك بنجاح',
            'player' => [
                'id' => $player->id,
                'subscription_date' => $player->subscription_date,
                'expiration_date' => $player->expiration_date,
                'fee' => $player->fee,
                'days_remaining' => $daysRemaining,
            ],
        ]);
    }

    public function profile($id)
    {
        $player = Player::with(['evaluations.videos', 'fights', 'weights', 'tournaments'])->findOrFail($id);
        return view('profile', compact('player'));
    }

    public function deleteEvaluationVideo($id)
    {
        $video = EvaluationVideo::findOrFail($id);

        // Delete the file from storage
        if (Storage::disk('public')->exists($video->video_path)) {
            Storage::disk('public')->delete($video->video_path);
        }

        $video->delete();

        return response()->json(['success' => true, 'message' => 'تم حذف الفيديو بنجاح!']);
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
