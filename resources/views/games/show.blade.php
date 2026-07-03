@extends('layouts.app')

@section('title', $game->title . ' — GTAVerse')
@section('meta_description', \Illuminate\Support\Str::limit($game->description, 150))

@php
    $heroImages = [
        'gta-iii' => '/images/hero-gta-iii.png',
        'gta-vice-city' => '/images/hero-gta-vc.png',
        'gta-san-andreas' => '/images/hero-gta-sa.png',
        'gta-iv' => '/images/hero-gta-iv.png',
        'gta-v' => '/images/hero-gta-v.png',
        'gta-vi' => '/images/hero-gta-vi.png',
    ];
@endphp

@section('content')
{{-- ==================================================================
     TEMA DINAMIS — halaman mengikuti warna tema & aksen game ini
================================================================== --}}
<style>
    #game-page {
        --gt: {{ $game->theme_color ?? '#22d3ee' }};   /* warna tema */
        --ga: {{ $game->accent_color ?? '#ec4899' }};  /* warna aksen */
    }

    /* Ganti seluruh aksen cyan bawaan menjadi warna aksen game */
    #game-page .text-cyan-400,
    #game-page .hover\:text-cyan-400:hover,
    #game-page .hover\:text-cyan-300:hover,
    #game-page .group:hover .group-hover\:text-cyan-400 { color: var(--ga) !important; }

    #game-page .text-cyan-400\/60 { color: color-mix(in srgb, var(--ga) 60%, transparent) !important; }

    #game-page .neon-text {
        text-shadow:
            0 0 10px color-mix(in srgb, var(--ga) 50%, transparent),
            0 0 22px color-mix(in srgb, var(--gt) 35%, transparent),
            0 0 44px color-mix(in srgb, var(--ga) 18%, transparent);
    }

    #game-page .glass-panel { border-color: color-mix(in srgb, var(--ga) 22%, transparent); }

    #game-page .card-gta:hover {
        border-color: color-mix(in srgb, var(--ga) 45%, transparent);
        box-shadow:
            0 0 20px color-mix(in srgb, var(--ga) 15%, transparent),
            0 0 40px color-mix(in srgb, var(--gt) 10%, transparent),
            0 8px 32px rgba(0, 0, 0, 0.4);
    }

    #game-page .badge-universe {
        border-color: color-mix(in srgb, var(--ga) 45%, transparent);
        background: color-mix(in srgb, var(--gt) 22%, transparent);
    }

    #game-page .btn-ghost:hover {
        background: color-mix(in srgb, var(--ga) 10%, transparent);
        border-color: color-mix(in srgb, var(--ga) 40%, transparent);
        box-shadow: 0 0 15px color-mix(in srgb, var(--ga) 18%, transparent);
    }

    #game-page .border-cyan-500\/15 { border-color: color-mix(in srgb, var(--ga) 20%, transparent) !important; }
    #game-page .from-cyan-500 { --tw-gradient-from: var(--ga) !important; }
</style>

<div id="game-page">
{{-- Latar halaman: gradien dominan dari warna tema & aksen game --}}
<div class="pointer-events-none fixed inset-0 -z-10"
     style="background:
        radial-gradient(70% 55% at 85% 0%, color-mix(in srgb, var(--ga) 22%, transparent) 0%, transparent 60%),
        radial-gradient(55% 45% at 8% 100%, color-mix(in srgb, var(--gt) 26%, transparent) 0%, transparent 58%),
        #09090b;"></div>

{{-- Hero detail game dengan efek parallax saat digulir --}}
<section id="game-hero" class="relative flex h-[72vh] items-end overflow-hidden scanlines">
    <div id="game-hero-bg" class="absolute inset-0 scale-110">
        @if ($game->hero_image)
            <img src="{{ asset('storage/' . $game->hero_image) }}" alt="{{ $game->title }}"
                 class="h-full w-full object-cover">
        @elseif (isset($heroImages[$game->slug]))
            <img src="{{ $heroImages[$game->slug] }}" alt="{{ $game->title }}"
                 class="h-full w-full object-cover">
        @else
            <div class="h-full w-full"
                 style="background:
                    radial-gradient(110% 110% at 85% 10%, {{ $game->accent_color }}59 0%, transparent 55%),
                    linear-gradient(135deg, {{ $game->theme_color }} 0%, #09090b 80%);"></div>
        @endif
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/50 to-transparent"></div>
    {{-- Semburat warna tema game di atas hero --}}
    <div class="absolute inset-0"
         style="background: linear-gradient(200deg, color-mix(in srgb, var(--ga) 14%, transparent) 0%, transparent 45%, color-mix(in srgb, var(--gt) 18%, transparent) 100%);"></div>
    <div class="bg-noise absolute inset-0 opacity-[0.05]"></div>

    <div class="relative z-10 mx-auto w-full max-w-7xl px-6 pb-14">
        <nav class="mb-5 text-xs uppercase tracking-widest text-zinc-400">
            <a href="{{ route('home') }}" class="hover:text-cyan-400 transition">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('games.index') }}" class="hover:text-cyan-400 transition">Games</a>
            <span class="mx-2">/</span>
            <span class="text-zinc-200">{{ $game->title }}</span>
        </nav>
        <div class="flex flex-wrap items-center gap-3">
            <span class="badge-universe">
                {{ $game->universe }} Universe
            </span>
            @if ($game->status === 'upcoming')
                <span class="rounded-full px-4 py-1.5 text-[11px] font-bold uppercase tracking-[0.25em] pulse-glow" style="background: linear-gradient(135deg, var(--gt), var(--ga));">Segera Hadir</span>
            @endif
        </div>
        <h1 class="mt-4 max-w-4xl font-display text-4xl uppercase leading-[0.95] neon-text sm:text-6xl lg:text-7xl">{{ $game->title }}</h1>
        <p class="mt-4 max-w-xl text-lg text-zinc-200/90">{{ $game->tagline }}</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-16">
    {{-- Informasi ringkas --}}
    <div class="reveal grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            'Tanggal Rilis' => $game->release_date?->format('d F Y') ?? 'Belum diumumkan',
            'Platform'      => $game->platforms ?? '-',
            'Latar'         => $game->setting ?? '-',
            'Status'        => $game->status === 'released' ? 'Sudah Rilis' : 'Akan Datang',
        ] as $label => $value)
            <div class="glass-panel p-5">
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-cyan-400/60">{{ $label }}</p>
                <p class="mt-2 font-semibold text-zinc-100">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    {{-- Deskripsi --}}
    <div class="reveal mt-14 max-w-3xl">
        <h2 class="font-display text-2xl uppercase">Tentang Game Ini</h2>
        <div class="mt-1 h-px w-16 bg-gradient-to-r from-cyan-500 to-transparent"></div>
        <p class="mt-4 leading-relaxed text-zinc-300">{{ $game->description }}</p>
    </div>

    {{-- Karakter dari game ini --}}
    @if ($game->characters->isNotEmpty())
        <div class="mt-16">
            <div class="reveal mb-7 flex items-end justify-between border-b border-cyan-500/15 pb-4">
                <h2 class="font-display text-2xl uppercase">Karakter Utama</h2>
                <a href="{{ route('characters.index', ['game' => $game->slug]) }}"
                   class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:text-cyan-300 transition">Semua Karakter &rarr;</a>
            </div>
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($game->characters as $character)
                    @include('characters._card', ['character' => $character])
                @endforeach
            </div>
        </div>
    @endif

    {{-- Artikel terkait --}}
    @if ($articles->isNotEmpty())
        <div class="mt-16">
            <div class="reveal mb-7 flex items-end justify-between border-b border-cyan-500/15 pb-4">
                <h2 class="font-display text-2xl uppercase">Berita Terkait</h2>
                <a href="{{ route('articles.index') }}"
                   class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:text-cyan-300 transition">Semua Artikel &rarr;</a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($articles as $article)
                    @include('articles._card', ['article' => $article])
                @endforeach
            </div>
        </div>
    @endif
</section>
</div> {{-- /#game-page --}}
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (!window.gsap || !window.ScrollTrigger) return;
    // Parallax latar hero saat digulir
    gsap.to('#game-hero-bg', {
        yPercent: 18,
        ease: 'none',
        scrollTrigger: {
            trigger: '#game-hero',
            start: 'top top',
            end: 'bottom top',
            scrub: true,
        },
    });
});
</script>
@endpush
