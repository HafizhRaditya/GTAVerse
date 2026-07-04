@extends('layouts.app')

@section('title', 'Articles & News — GTAVerse')

@section('content')
<section class="mx-auto max-w-7xl px-6 pb-24 pt-36">
    <div class="reveal flex flex-wrap items-end justify-between gap-6">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Editorial</p>
            <h1 class="mt-3 font-display text-5xl uppercase sm:text-6xl">Articles &amp; <span class="text-gta-accent">News</span></h1>
            <p class="mt-4 text-zinc-400">The latest news, reviews, and guides from across the Grand Theft Auto universe.</p>
        </div>

        {{-- Search --}}
        <form action="{{ route('articles.index') }}" method="GET" class="flex w-full max-w-md gap-2">
            @if ($category)
                <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <input type="search" name="q" value="{{ $search }}" placeholder="Search articles..."
                   class="w-full rounded-full border border-cyan-500/20 bg-zinc-900/70 px-5 py-3 text-sm text-zinc-100 placeholder-zinc-500 outline-none transition focus:border-cyan-500/50 focus:shadow-[0_0_15px_rgba(34,211,238,0.1)] backdrop-blur">
            <button type="submit" class="btn-primary shrink-0">Search</button>
        </form>
    </div>

    {{-- Category filter --}}
    <div class="reveal mt-10 flex flex-wrap gap-3">
        <a href="{{ route('articles.index', array_filter(['q' => $search])) }}"
           class="rounded-full px-5 py-2 text-xs font-bold uppercase tracking-widest transition
                  {{ ! $category ? 'filter-active' : 'border border-white/15 text-zinc-300 hover:bg-cyan-500/10 hover:border-cyan-500/30' }}">
            All
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('articles.index', array_filter(['category' => $cat->slug, 'q' => $search])) }}"
               class="rounded-full px-5 py-2 text-xs font-bold uppercase tracking-widest transition
                      {{ $category === $cat->slug ? 'filter-active' : 'border border-white/15 text-zinc-300 hover:bg-cyan-500/10 hover:border-cyan-500/30' }}">
                {{ $cat->name }} <span class="opacity-60">({{ $cat->articles_count }})</span>
            </a>
        @endforeach
    </div>

    @if ($search)
        <p class="mt-8 text-sm text-zinc-400">
            Showing {{ $articles->total() }} {{ Str::plural('result', $articles->total()) }} for
            &ldquo;<span class="font-semibold text-cyan-400">{{ $search }}</span>&rdquo;
        </p>
    @endif

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($articles as $article)
            @include('articles._card', ['article' => $article])
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-cyan-500/20 py-20 text-center">
                <p class="font-display text-2xl uppercase text-zinc-400">No Results</p>
                <p class="mt-2 text-sm text-zinc-500">We couldn't find the article you're looking for. Try a different keyword or category.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($articles->hasPages())
        <nav class="mt-14 flex items-center justify-between" aria-label="Page navigation">
            @if ($articles->onFirstPage())
                <span class="btn-ghost cursor-not-allowed opacity-40">&larr; Previous</span>
            @else
                <a href="{{ $articles->previousPageUrl() }}" class="btn-ghost">&larr; Previous</a>
            @endif

            <span class="text-sm text-zinc-500">Page {{ $articles->currentPage() }} of {{ $articles->lastPage() }}</span>

            @if ($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}" class="btn-ghost">Next &rarr;</a>
            @else
                <span class="btn-ghost cursor-not-allowed opacity-40">Next &rarr;</span>
            @endif
        </nav>
    @endif
</section>
@endsection
