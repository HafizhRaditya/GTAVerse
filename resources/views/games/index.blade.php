@extends('layouts.app')

@section('title', 'Semua Game — GTAVerse')

@section('content')
<section class="mx-auto max-w-7xl px-6 pb-24 pt-36">
    <div class="reveal max-w-2xl">
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Katalog</p>
        <h1 class="mt-3 font-display text-5xl uppercase sm:text-6xl">Semua Game <span class="text-gta-accent">GTA</span></h1>
        <p class="mt-4 text-zinc-400">Seluruh entri seri Grand Theft Auto, terbagi dalam dua semesta cerita.</p>
    </div>

    {{-- Filter universe --}}
    <div class="reveal mt-10 flex flex-wrap gap-3">
        @foreach ([null => 'Semua', '3D' => '3D Universe', 'HD' => 'HD Universe'] as $value => $label)
            <a href="{{ route('games.index', array_filter(['universe' => $value])) }}"
               class="rounded-full px-5 py-2 text-xs font-bold uppercase tracking-widest transition
                      {{ $universe === $value || (! $value && ! $universe)
                          ? 'filter-active'
                          : 'border border-white/15 text-zinc-300 hover:bg-cyan-500/10 hover:border-cyan-500/30' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="mt-10 grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
        @forelse ($games as $game)
            @include('games._card', ['game' => $game])
        @empty
            <p class="col-span-full py-16 text-center text-zinc-500">Belum ada game pada filter ini.</p>
        @endforelse
    </div>
</section>
@endsection
