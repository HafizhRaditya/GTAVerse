@extends('layouts.app')

@section('title', $character->name . ' — GTAVerse Character Profile')
@section('meta_description', \Illuminate\Support\Str::limit($character->bio, 150))

@section('content')
<section class="mx-auto max-w-6xl px-6 pb-24 pt-36">
    <nav class="reveal mb-8 text-xs uppercase tracking-widest text-zinc-400">
        <a href="{{ route('home') }}" class="hover:text-cyan-400 transition">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('characters.index') }}" class="hover:text-cyan-400 transition">Characters</a>
        <span class="mx-2">/</span>
        <span class="text-zinc-200">{{ $character->name }}</span>
    </nav>

    <div class="grid gap-10 md:grid-cols-[320px,1fr]">
        {{-- Photo / monogram --}}
        <div class="reveal">
            <div class="relative flex aspect-[3/4] items-center justify-center overflow-hidden rounded-3xl border border-white/10"
                 style="background:
                    radial-gradient(100% 100% at 20% 90%, {{ $character->game?->accent_color ?? '#7c3aed' }}4d 0%, transparent 55%),
                    linear-gradient(160deg, {{ $character->game?->theme_color ?? '#27272a' }}, #09090b 85%);">
                @if ($character->photo)
                    <img src="{{ asset('storage/' . $character->photo) }}" alt="{{ $character->name }}"
                         class="h-full w-full object-cover object-top">
                @else
                    <span class="font-display text-8xl uppercase text-white/80">{{ $character->initials }}</span>
                @endif
                <div class="bg-noise absolute inset-0 opacity-[0.06]"></div>
                {{-- Bottom gradient overlay --}}
                <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-zinc-900/80 to-transparent"></div>
            </div>
        </div>

        {{-- Details --}}
        <div class="reveal">
            @if ($character->game)
                <a href="{{ route('games.show', $character->game) }}"
                   class="badge-universe inline-flex text-zinc-300 transition hover:bg-white/10">
                    {{ $character->game->title }} &middot; {{ $character->game->universe }} Universe
                </a>
            @endif

            <h1 class="mt-4 font-display text-4xl uppercase leading-[0.95] neon-text sm:text-6xl">{{ $character->name }}</h1>
            @if ($character->alias)
                <p class="mt-2 text-lg italic text-cyan-400">&ldquo;{{ $character->alias }}&rdquo;</p>
            @endif

            <dl class="mt-8 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    'Role'        => $character->role,
                    'Voice Actor' => $character->voice_actor ?? 'None / unvoiced',
                    'Debut'       => $character->game?->release_year ?? '-',
                ] as $label => $value)
                    <div class="glass-panel p-4">
                        <dt class="text-[10px] font-bold uppercase tracking-[0.25em] text-cyan-400/60">{{ $label }}</dt>
                        <dd class="mt-2 text-sm font-semibold text-zinc-100">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>

            <h2 class="mt-10 font-display text-xl uppercase">Biography</h2>
            <div class="mt-1 h-px w-16 bg-gradient-to-r from-cyan-500 to-transparent"></div>
            <p class="mt-3 whitespace-pre-line leading-relaxed text-zinc-300">{{ $character->bio }}</p>
        </div>
    </div>

    @if ($others->isNotEmpty())
        <div class="mt-20">
            <div class="section-divider mb-10"></div>
            <h2 class="reveal mb-7 border-b border-cyan-500/15 pb-4 font-display text-2xl uppercase">
                Other Characters from {{ $character->game?->title }}
            </h2>
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($others as $other)
                    @include('characters._card', ['character' => $other])
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
