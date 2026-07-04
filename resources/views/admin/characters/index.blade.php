@extends('admin.layouts.admin')

@section('title', 'Manage Characters')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Manage <span class="text-gta-accent">Characters</span></h1>
            <p class="mt-2 text-sm text-zinc-400">The character encyclopedia across the entire GTA series.</p>
        </div>
        <a href="{{ route('admin.characters.create') }}" class="btn-primary">+ Add Character</a>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search character names…" class="form-input max-w-xs">
        <select name="game" class="form-input w-auto">
            <option value="">All Games</option>
            @foreach ($games as $game)
                <option value="{{ $game->id }}" @selected(request('game') == $game->id)>{{ $game->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-ghost !px-5 !py-2.5">Search</button>
    </form>

    <div class="glass-panel overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Game</th>
                    <th>Role</th>
                    <th>Voice Actor</th>
                    <th>Protagonist</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($characters as $character)
                    <tr>
                        <td>
                            @if ($character->photo)
                                <img src="{{ asset('storage/' . $character->photo) }}" alt="{{ $character->name }}"
                                     class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-800 text-xs font-bold text-cyan-400">
                                    {{ $character->initials }}
                                </div>
                            @endif
                        </td>
                        <td class="font-semibold">{{ $character->name }}</td>
                        <td>
                            @if ($character->game)
                                <span class="badge-admin badge-cyan">{{ $character->game->title }}</span>
                            @endif
                        </td>
                        <td class="text-zinc-400">{{ $character->role ?? '—' }}</td>
                        <td class="text-zinc-400">{{ $character->voice_actor ?? '—' }}</td>
                        <td>{{ $character->is_protagonist ? '★' : '—' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.characters.edit', $character) }}" class="btn-admin-sm btn-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.characters.destroy', $character) }}"
                                      onsubmit="return confirm('Delete the character \'{{ addslashes($character->name) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-zinc-500">No characters yet. <a href="{{ route('admin.characters.create') }}" class="text-cyan-400 hover:underline">Add one now</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $characters->links('admin.partials.pagination') }}</div>
@endsection
