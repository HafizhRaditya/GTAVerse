<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Character;
use App\Models\Game;

class HomeController extends Controller
{
    public function index()
    {
        // Featured games for the hero slider & scroll journey section
        $featuredGames = Game::featured()->ordered()->get();

        // Game catalog per universe
        $threeDGames = Game::universe('3D')->ordered()->get();
        $hdGames     = Game::universe('HD')->ordered()->get();

        // Articles
        $headline       = Article::published()->where('is_headline', true)->latest('published_at')->first();
        $latestArticles = Article::published()
            ->when($headline, fn ($q) => $q->where('id', '!=', $headline->id))
            ->with(['category', 'game'])
            ->latest('published_at')
            ->take(6)
            ->get();

        // Protagonist characters for the teaser section
        $protagonists = Character::protagonists()
            ->with('game')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('home', compact(
            'featuredGames', 'threeDGames', 'hdGames',
            'headline', 'latestArticles', 'protagonists'
        ));
    }
}
