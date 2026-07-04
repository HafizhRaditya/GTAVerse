<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::with(['category', 'author'])
            ->when($request->filled('q'), fn ($q) => $q->search($request->q))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.articles.create', [
            'article'    => new Article(),
            'categories' => Category::orderBy('name')->get(),
            'games'      => Game::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $data['user_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($data['status'] === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', "Article \"{$article->title}\" was added successfully.");
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', [
            'article'    => $article,
            'categories' => Category::orderBy('name')->get(),
            'games'      => Game::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $this->validated($request, $article);

        if (blank($data['slug'])) {
            unset($data['slug']);
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        } else {
            unset($data['featured_image']);
        }

        if ($data['status'] === 'published' && blank($data['published_at'] ?? null) && blank($article->published_at)) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', "Article \"{$article->title}\" was updated successfully.");
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $title = $article->title;
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', "Article \"{$title}\" was deleted successfully.");
    }

    private function validated(Request $request, ?Article $article = null): array
    {
        return $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'slug'           => ['nullable', 'string', 'max:255', Rule::unique('articles', 'slug')->ignore($article?->id)],
            'category_id'    => ['nullable', 'exists:categories,id'],
            'game_id'        => ['nullable', 'exists:games,id'],
            'excerpt'        => ['nullable', 'string', 'max:500'],
            'body'           => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'status'         => ['required', Rule::in(['draft', 'published'])],
            'published_at'   => ['nullable', 'date'],
            'is_headline'    => ['nullable', 'boolean'],
        ]) + [
            'is_headline' => $request->boolean('is_headline'),
        ];
    }
}
