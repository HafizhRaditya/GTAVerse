<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(Request $request): View
    {
        $games = Game::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->q.'%'))
            ->when($request->filled('universe'), fn ($q) => $q->where('universe', $request->universe))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.games.index', compact('games'));
    }

    public function create(): View
    {
        return view('admin.games.create', ['game' => new Game()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        foreach (['cover_image', 'hero_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('games', 'public');
            }
        }

        $game = Game::create($data);

        return redirect()->route('admin.games.index')
            ->with('success', "Game \"{$game->title}\" berhasil ditambahkan.");
    }

    public function edit(Game $game): View
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game): RedirectResponse
    {
        $data = $this->validated($request, $game);

        if (blank($data['slug'])) {
            unset($data['slug']);
        }

        foreach (['cover_image', 'hero_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($game->{$field}) {
                    Storage::disk('public')->delete($game->{$field});
                }
                $data[$field] = $request->file($field)->store('games', 'public');
            } else {
                unset($data[$field]);
            }
        }

        $game->update($data);

        return redirect()->route('admin.games.index')
            ->with('success', "Game \"{$game->title}\" berhasil diperbarui.");
    }

    public function destroy(Game $game): RedirectResponse
    {
        foreach (['cover_image', 'hero_image'] as $field) {
            if ($game->{$field}) {
                Storage::disk('public')->delete($game->{$field});
            }
        }

        $title = $game->title;
        $game->delete();

        return redirect()->route('admin.games.index')
            ->with('success', "Game \"{$title}\" berhasil dihapus.");
    }

    private function validated(Request $request, ?Game $game = null): array
    {
        return $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', Rule::unique('games', 'slug')->ignore($game?->id)],
            'universe'     => ['required', Rule::in(['3D', 'HD'])],
            'status'       => ['required', Rule::in(['released', 'upcoming'])],
            'release_date' => ['nullable', 'date'],
            'platforms'    => ['nullable', 'string', 'max:255'],
            'setting'      => ['nullable', 'string', 'max:255'],
            'tagline'      => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'cover_image'  => ['nullable', 'image', 'max:4096'],
            'hero_image'   => ['nullable', 'image', 'max:4096'],
            'theme_color'  => ['nullable', 'string', 'max:20'],
            'accent_color' => ['nullable', 'string', 'max:20'],
            'is_featured'  => ['nullable', 'boolean'],
            'sort_order'   => ['nullable', 'integer'],
        ]) + [
            'is_featured' => $request->boolean('is_featured'),
            'sort_order'  => (int) $request->input('sort_order', 0),
        ];
    }
}
