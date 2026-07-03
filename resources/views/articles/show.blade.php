@extends('layouts.app')

@section('title', $article->title . ' — GTAVerse')
@section('meta_description', $article->excerpt)

@php
    $articleImages = ['/images/article-placeholder-1.png', '/images/article-placeholder-2.png'];
    $imgIdx = crc32($article->slug ?? $article->id ?? '') % count($articleImages);
@endphp

@section('content')
<article class="mx-auto max-w-4xl px-6 pb-24 pt-36">
    <header class="reveal">
        <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold uppercase tracking-widest">
            @if ($article->category)
                <a href="{{ route('articles.index', ['kategori' => $article->category->slug]) }}"
                   class="rounded-full px-3 py-1 text-white hover:opacity-90 transition" style="background: linear-gradient(135deg, #0891b2, #ec4899);">{{ $article->category->name }}</a>
            @endif
            @if ($article->game)
                <a href="{{ route('games.show', $article->game) }}"
                   class="badge-universe text-zinc-300 hover:bg-white/10 transition">{{ $article->game->title }}</a>
            @endif
        </div>

        <h1 class="mt-5 text-3xl font-extrabold leading-tight sm:text-4xl lg:text-5xl">{{ $article->title }}</h1>

        <div class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-zinc-400">
            <span>Oleh <span class="font-semibold text-zinc-200">{{ $article->author?->name ?? 'Redaksi' }}</span></span>
            <span>{{ $article->published_at->format('d F Y') }}</span>
            <span>{{ $article->reading_time }} menit baca</span>
            <span>{{ number_format($article->views, 0, ',', '.') }}x dibaca</span>
        </div>
    </header>

    <div class="reveal mt-9 overflow-hidden rounded-3xl border border-white/10">
        @if ($article->featured_image)
            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                 class="h-auto w-full object-cover">
        @else
            <img src="{{ $articleImages[$imgIdx] }}" alt="{{ $article->title }}"
                 class="h-auto w-full object-cover">
        @endif
    </div>

    <div class="prose prose-invert prose-pink mt-10 max-w-none prose-headings:font-extrabold prose-a:text-cyan-400">
        {!! $article->body !!}
    </div>

    <div class="mt-12 border-t border-cyan-500/15 pt-6">
        <a href="{{ route('articles.index') }}" class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:text-cyan-300 transition">
            &larr; Kembali ke Semua Artikel
        </a>
    </div>
</article>

@if ($related->isNotEmpty())
    <section class="border-t border-cyan-500/10 bg-zinc-900/30">
        <div class="mx-auto max-w-7xl px-6 py-16">
            <h2 class="reveal mb-8 font-display text-2xl uppercase">Artikel Terkait</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $item)
                    @include('articles._card', ['article' => $item])
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
