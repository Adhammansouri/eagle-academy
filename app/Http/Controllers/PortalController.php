<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PortalController extends Controller
{
    public function index()
    {
        return view('portal.index');
    }

    public function check(Request $request)
    {
        $request->validate([
            'search_term' => 'required|string|max:255',
        ]);

        $term = $request->input('search_term');

        // Search by player_code or phone_number
        $player = Player::with(['evaluations', 'fights', 'tournaments'])
                        ->where('player_code', $term)
                        ->orWhere('phone_number', $term)
                        ->first();

        if (!$player) {
            return back()->with('error', 'عذراً، لم نتمكن من العثور على أي لاعب بهذا الكود أو رقم الهاتف.');
        }

        return view('portal.index', compact('player'));
    }
}
