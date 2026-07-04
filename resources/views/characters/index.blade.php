@extends('layouts.app')

@section('title', 'Character Profiles — GTAVerse')

@section('content')
<section class="mx-auto max-w-7xl px-6 pb-24 pt-36">
    <div class="reveal max-w-2xl">
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Encyclopedia</p>
        <h1 class="mt-3 font-display text-5xl uppercase sm:text-6xl">Character <span class="text-gta-accent">Profiles</span></h1>
        <p class="mt-4 text-zinc-400">The leading characters of every Grand Theft Auto entry — their stories, roles, and voice actors.</p>
    </div>

    {{-- Filter by game --}}
    <div class="reveal mt-10 flex flex-wrap gap-3">
        <a href="{{ route('characters.index') }}"
           class="rounded-full px-5 py-2 text-xs font-bold uppercase tracking-widest transition
                  {{ ! $gameSlug ? 'filter-active' : 'border border-white/15 text-zinc-300 hover:bg-cyan-500/10 hover:border-cyan-500/30' }}">
            All
        </a>
        @foreach ($games as $g)
            <a href="{{ route('characters.index', ['game' => $g->slug]) }}"
               class="rounded-full px-5 py-2 text-xs font-bold uppercase tracking-widest transition
                      {{ $gameSlug === $g->slug ? 'filter-active' : 'border border-white/15 text-zinc-300 hover:bg-cyan-500/10 hover:border-cyan-500/30' }}">
                {{ str_replace('Grand Theft Auto', 'GTA', $g->title) }}
            </a>
        @endforeach
    </div>

    <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
        @forelse ($characters as $character)
            @include('characters._card', ['character' => $character])
        @empty
            <p class="col-span-full py-16 text-center text-zinc-500">No characters match this filter yet.</p>
        @endforelse
    </div>
</section>
@endsection
