@extends('admin.layouts.admin')

@section('title', 'Manage Articles')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Manage <span class="text-gta-accent">Articles</span></h1>
            <p class="mt-2 text-sm text-zinc-400">News and articles published on the GTAVerse portal.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-primary">+ Write Article</a>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title / article body…" class="form-input max-w-xs">
        <select name="status" class="form-input w-auto">
            <option value="">All Statuses</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
        </select>
        <button type="submit" class="btn-ghost !px-5 !py-2.5">Search</button>
    </form>

    <div class="glass-panel overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Views</th>
                    <th>Headline</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt=""
                                     class="h-10 w-16 rounded object-cover">
                            @else
                                <div class="flex h-10 w-16 items-center justify-center rounded bg-zinc-800 text-[10px] text-zinc-500">N/A</div>
                            @endif
                        </td>
                        <td class="max-w-xs font-semibold">{{ Str::limit($article->title, 45) }}</td>
                        <td>
                            @if ($article->category)
                                <span class="badge-admin badge-cyan">{{ $article->category->name }}</span>
                            @else
                                <span class="text-zinc-600">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-admin {{ $article->status === 'published' ? 'badge-green' : 'badge-gray' }}">
                                {{ $article->status === 'published' ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="text-zinc-400">{{ $article->published_at?->format('d M Y H:i') ?? '—' }}</td>
                        <td class="text-zinc-400">{{ number_format($article->views) }}</td>
                        <td>{{ $article->is_headline ? '★' : '—' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn-admin-sm btn-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                                      onsubmit="return confirm('Delete the article \'{{ addslashes($article->title) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-10 text-center text-zinc-500">No articles yet. <a href="{{ route('admin.articles.create') }}" class="text-cyan-400 hover:underline">Write one now</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $articles->links('admin.partials.pagination') }}</div>
@endsection
