<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CharacterController extends Controller
{
    public function index(Request $request): View
    {
        $characters = Character::with('game')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->when($request->filled('game'), fn ($q) => $q->where('game_id', $request->game))
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('admin.characters.index', [
            'characters' => $characters,
            'games'      => Game::orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.characters.create', [
            'character' => new Character(),
            'games'     => Game::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('characters', 'public');
        }

        $character = Character::create($data);

        return redirect()->route('admin.characters.index')
            ->with('success', "Karakter \"{$character->name}\" berhasil ditambahkan.");
    }

    public function edit(Character $character): View
    {
        return view('admin.characters.edit', [
            'character' => $character,
            'games'     => Game::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Character $character): RedirectResponse
    {
        $data = $this->validated($request, $character);

        if (blank($data['slug'])) {
            unset($data['slug']);
        }

        if ($request->hasFile('photo')) {
            if ($character->photo) {
                Storage::disk('public')->delete($character->photo);
            }
            $data['photo'] = $request->file('photo')->store('characters', 'public');
        } else {
            unset($data['photo']);
        }

        $character->update($data);

        return redirect()->route('admin.characters.index')
            ->with('success', "Karakter \"{$character->name}\" berhasil diperbarui.");
    }

    public function destroy(Character $character): RedirectResponse
    {
        if ($character->photo) {
            Storage::disk('public')->delete($character->photo);
        }

        $name = $character->name;
        $character->delete();

        return redirect()->route('admin.characters.index')
            ->with('success', "Karakter \"{$name}\" berhasil dihapus.");
    }

    private function validated(Request $request, ?Character $character = null): array
    {
        return $request->validate([
            'game_id'        => ['required', 'exists:games,id'],
            'name'           => ['required', 'string', 'max:255'],
            'slug'           => ['nullable', 'string', 'max:255', Rule::unique('characters', 'slug')->ignore($character?->id)],
            'alias'          => ['nullable', 'string', 'max:255'],
            'role'           => ['nullable', 'string', 'max:255'],
            'voice_actor'    => ['nullable', 'string', 'max:255'],
            'bio'            => ['nullable', 'string'],
            'photo'          => ['nullable', 'image', 'max:4096'],
            'is_protagonist' => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer'],
        ]) + [
            'is_protagonist' => $request->boolean('is_protagonist'),
            'sort_order'     => (int) $request->input('sort_order', 0),
        ];
    }
}
