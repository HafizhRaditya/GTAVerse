<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $universe = $request->query('universe'); // '3D' | 'HD' | null

        $games = Game::ordered()
            ->when(in_array($universe, ['3D', 'HD']), fn ($q) => $q->universe($universe))
            ->get();

        return view('games.index', compact('games', 'universe'));
    }

    public function show(Game $game)
    {
        $game->load('characters');

        $articles = $game->articles()
            ->published()
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('games.show', compact('game', 'articles'));
    }
}
