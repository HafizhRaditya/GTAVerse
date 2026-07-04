@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide sm:text-4xl">
            Admin <span class="text-gta-accent">Dashboard</span>
        </h1>
        <p class="mt-2 text-sm text-zinc-400">Welcome, {{ auth()->user()->name }}. Manage all GTAVerse content from here.</p>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5">
        <a href="{{ route('admin.games.index') }}" class="card-gta p-5">
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-400/70">Games</p>
            <p class="mt-2 font-display text-4xl">{{ $stats['games'] }}</p>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="card-gta p-5">
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-pink-400/70">Articles</p>
            <p class="mt-2 font-display text-4xl">{{ $stats['articles'] }}</p>
            <p class="mt-1 text-xs text-zinc-500">{{ $stats['published'] }} published</p>
        </a>
        <a href="{{ route('admin.characters.index') }}" class="card-gta p-5">
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-teal-400/70">Characters</p>
            <p class="mt-2 font-display text-4xl">{{ $stats['characters'] }}</p>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="card-gta p-5">
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-400/70">Categories</p>
            <p class="mt-2 font-display text-4xl">{{ $stats['categories'] }}</p>
            <p class="mt-1 text-xs text-zinc-500">{{ number_format($stats['views']) }} article views</p>
        </a>
        <a href="{{ route('admin.messages.index') }}" class="card-gta p-5">
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-pink-400/70">Suggestions</p>
            <p class="mt-2 font-display text-4xl">{{ $stats['messages'] }}</p>
            <p class="mt-1 text-xs {{ $stats['unread'] > 0 ? 'text-pink-400' : 'text-zinc-500' }}">{{ $stats['unread'] }} unread</p>
        </a>
    </div>

    {{-- Quick actions --}}
    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('admin.articles.create') }}" class="btn-primary">+ Write Article</a>
        <a href="{{ route('admin.games.create') }}" class="btn-ghost">+ Add Game</a>
        <a href="{{ route('admin.characters.create') }}" class="btn-ghost">+ Add Character</a>
    </div>

    {{-- Latest articles --}}
    <div class="mt-10">
        <h2 class="mb-4 font-display text-xl uppercase tracking-wide text-zinc-200">Latest Articles</h2>
        <div class="glass-panel overflow-x-auto">
            <table class="admin-table w-full">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestArticles as $article)
                        <tr>
                            <td class="font-semibold">{{ Str::limit($article->title, 55) }}</td>
                            <td>
                                @if ($article->category)
                                    <span class="badge-admin badge-cyan">{{ $article->category->name }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-admin {{ $article->status === 'published' ? 'badge-green' : 'badge-gray' }}">
                                    {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="text-zinc-400">{{ $article->published_at?->format('d M Y') ?? '—' }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn-admin-sm btn-edit">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-8 text-center text-zinc-500">No articles yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
