<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->query('q');
        $category = $request->query('kategori');

        $articles = Article::published()
            ->with(['category', 'game'])
            ->search($search)
            ->when($category, fn ($q) => $q->whereHas(
                'category', fn ($c) => $c->where('slug', $category)
            ))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::withCount('articles')->orderBy('name')->get();

        return view('articles.index', compact('articles', 'categories', 'search', 'category'));
    }

    public function show(Article $article)
    {
        // Artikel draft tidak boleh diakses publik
        abort_unless(
            $article->status === 'published'
                && $article->published_at
                && $article->published_at->isPast(),
            404
        );

        // Penghitung jumlah dibaca (views)
        $article->increment('views');

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category_id, fn ($q) => $q->where('category_id', $article->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}
