@extends('admin.layouts.admin')

@section('title', 'Manage Games')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Manage <span class="text-gta-accent">Games</span></h1>
            <p class="mt-2 text-sm text-zinc-400">The GTA game catalog — from the 3D Universe to the HD Universe.</p>
        </div>
        <a href="{{ route('admin.games.create') }}" class="btn-primary">+ Add Game</a>
    </div>

    {{-- Search & filter --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search game titles…"
               class="form-input max-w-xs">
        <select name="universe" class="form-input w-auto">
            <option value="">All Universes</option>
            <option value="3D" @selected(request('universe') === '3D')>3D Universe</option>
            <option value="HD" @selected(request('universe') === 'HD')>HD Universe</option>
        </select>
        <button type="submit" class="btn-ghost !px-5 !py-2.5">Search</button>
    </form>

    <div class="glass-panel overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Universe</th>
                    <th>Release</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($games as $game)
                    <tr>
                        <td>
                            @if ($game->cover_image)
                                <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}"
                                     class="h-12 w-9 rounded object-cover">
                            @else
                                <div class="flex h-12 w-9 items-center justify-center rounded bg-zinc-800 text-[10px] text-zinc-500">N/A</div>
                            @endif
                        </td>
                        <td class="font-semibold">{{ $game->title }}</td>
                        <td><span class="badge-admin {{ $game->universe === '3D' ? 'badge-cyan' : 'badge-pink' }}">{{ $game->universe }} Universe</span></td>
                        <td class="text-zinc-400">{{ $game->release_date?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <span class="badge-admin {{ $game->status === 'released' ? 'badge-green' : 'badge-gray' }}">
                                {{ $game->status === 'released' ? 'Released' : 'Upcoming' }}
                            </span>
                        </td>
                        <td>{{ $game->is_featured ? '★' : '—' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.games.edit', $game) }}" class="btn-admin-sm btn-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.games.destroy', $game) }}"
                                      onsubmit="return confirm('Delete the game \'{{ addslashes($game->title) }}\'? All of its characters will be deleted as well.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-zinc-500">No games yet. <a href="{{ route('admin.games.create') }}" class="text-cyan-400 hover:underline">Add one now</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $games->links('admin.partials.pagination') }}</div>
@endsection
