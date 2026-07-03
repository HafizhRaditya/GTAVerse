<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Game;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $gameSlug = $request->query('game');

        $characters = Character::with('game')
            ->when($gameSlug, fn ($q) => $q->whereHas(
                'game', fn ($g) => $g->where('slug', $gameSlug)
            ))
            ->orderBy('sort_order')
            ->get();

        $games = Game::ordered()->has('characters')->get(['id', 'title', 'slug']);

        return view('characters.index', compact('characters', 'games', 'gameSlug'));
    }

    public function show(Character $character)
    {
        $character->load('game');

        $others = Character::where('id', '!=', $character->id)
            ->where('game_id', $character->game_id)
            ->orderBy('sort_order')
            ->get();

        return view('characters.show', compact('character', 'others'));
    }
}
