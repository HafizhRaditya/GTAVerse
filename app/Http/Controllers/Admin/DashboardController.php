<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Character;
use App\Models\Game;
use App\Models\Message;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'games'      => Game::count(),
                'articles'   => Article::count(),
                'published'  => Article::where('status', 'published')->count(),
                'characters' => Character::count(),
                'categories' => Category::count(),
                'views'      => Article::sum('views'),
                'messages'   => Message::count(),
                'unread'     => Message::unread()->count(),
            ],
            'latestArticles' => Article::with('category')
                ->latest('created_at')
                ->take(6)
                ->get(),
        ]);
    }
}
