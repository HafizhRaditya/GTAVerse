@extends('layouts.app')

@section('title', 'GTAVerse — Portal Berita Grand Theft Auto')

@section('content')

{{-- ==================================================================
     HERO IMAGE MAP — peta slug → gambar hero statik
================================================================== --}}
@php
    $heroImages = [
        'gta-iii' => '/images/hero-gta-iii.png',
        'gta-vice-city' => '/images/hero-gta-vc.png',
        'gta-san-andreas' => '/images/hero-gta-sa.png',
        'gta-iv' => '/images/hero-gta-iv.png',
        'gta-v' => '/images/hero-gta-v.png',
        'gta-vi' => '/images/hero-gta-vi.png',
    ];
    $articleImages = ['/images/article-placeholder-1.png', '/images/article-placeholder-2.png'];
@endphp

{{-- ==================================================================
     1. HERO SLIDER — berganti otomatis & manual antar game unggulan
================================================================== --}}
<section id="hero" class="relative h-screen overflow-hidden scanlines">
    @forelse ($featuredGames as $i => $game)
        <div class="hero-slide absolute inset-0 {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}">
            {{-- Latar: gambar hero bila ada, jika tidak gunakan gambar statik atau gradien --}}
            @if ($game->hero_image)
                <img src="{{ asset('storage/' . $game->hero_image) }}" alt="{{ $game->title }}"
                     class="absolute inset-0 h-full w-full object-cover">
            @elseif (isset($heroImages[$game->slug]))
                <img src="{{ $heroImages[$game->slug] }}" alt="{{ $game->title }}"
                     class="absolute inset-0 h-full w-full object-cover">
            @else
                <div class="absolute inset-0"
                     style="background:
                        radial-gradient(120% 120% at 82% 8%, {{ $game->accent_color }}59 0%, transparent 55%),
                        linear-gradient(135deg, {{ $game->theme_color }} 0%, #09090b 78%);"></div>
            @endif
            {{-- Dark overlay gradient --}}
            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-zinc-950/20"></div>
            <div class="bg-noise absolute inset-0 opacity-[0.06]"></div>

            {{-- Konten slide --}}
            <div class="relative z-10 mx-auto flex h-full max-w-7xl flex-col justify-center px-6">
                <span class="hero-el mb-5 w-fit badge-universe">
                    {{ $game->universe }} Universe
                    @if ($game->status === 'upcoming') · <span class="text-pink-400">Segera Hadir</span> @endif
                </span>
                <h1 class="hero-el max-w-4xl font-display text-5xl uppercase leading-[0.95] drop-shadow-lg sm:text-7xl lg:text-8xl neon-text">
                    {{ $game->title }}
                </h1>
                <p class="hero-el mt-6 max-w-xl text-lg text-zinc-100/90 sm:text-xl">
                    {{ $game->tagline }}
                </p>
                <div class="hero-el mt-9 flex flex-wrap gap-4">
                    <a href="{{ route('games.show', $game) }}" class="btn-primary">Jelajahi Game</a>
                    <a href="{{ route('articles.index') }}" class="btn-ghost">Baca Berita</a>
                </div>
            </div>
        </div>
    @empty
        <div class="flex h-full items-center justify-center animated-gradient">
            <div class="text-center">
                <p class="font-display text-4xl uppercase neon-text text-cyan-400">Welcome to Los Santos</p>
                <p class="mt-4 text-zinc-500">Belum ada game unggulan. Tandai game sebagai unggulan melalui panel admin.</p>
            </div>
        </div>
    @endforelse

    @if ($featuredGames->count() > 1)
        {{-- Kontrol slider --}}
        <div class="absolute bottom-10 left-1/2 z-20 flex -translate-x-1/2 items-center gap-4">
            <button id="hero-prev" class="hero-arrow" aria-label="Slide sebelumnya">&larr;</button>
            <div class="flex items-center gap-2">
                @foreach ($featuredGames as $i => $game)
                    <button class="hero-dot {{ $i === 0 ? 'is-active' : '' }}" data-goto="{{ $i }}"
                            aria-label="Ke slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
            <button id="hero-next" class="hero-arrow" aria-label="Slide berikutnya">&rarr;</button>
        </div>
        <div id="hero-progress" class="absolute bottom-0 left-0 z-20 h-1" style="width: 0%; background: linear-gradient(90deg, #22d3ee, #ec4899);"></div>
    @endif

    {{-- Petunjuk gulir --}}
    <div class="absolute bottom-10 right-8 z-20 hidden animate-bounce flex-col items-center gap-2 text-[10px] font-bold uppercase tracking-[0.3em] text-zinc-400 md:flex">
        <span>Gulir</span>
        <span class="h-8 w-px bg-gradient-to-b from-cyan-500 to-transparent"></span>
    </div>
</section>

{{-- Neon section divider --}}
<div class="section-divider"></div>

{{-- ==================================================================
     2. SCROLL JOURNEY — panel game berganti saat digulir
================================================================== --}}
@if ($featuredGames->count() > 1)
    <section id="journey" class="relative" style="height: {{ ($featuredGames->count() + 1) * 100 }}vh">
        <div class="sticky top-0 flex h-screen items-center justify-center overflow-hidden">

            <div class="absolute left-6 top-24 z-20 text-[11px] font-bold uppercase tracking-[0.35em] text-zinc-400">
                Perjalanan Semesta <span class="text-gta-accent">GTA</span><br>
                <span class="text-zinc-600">3D Universe &rarr; HD Universe</span>
            </div>

            @foreach ($featuredGames as $i => $game)
                <article class="journey-panel absolute inset-0 flex items-center justify-center" data-panel="{{ $i }}">
                    @if ($game->hero_image)
                        <img src="{{ asset('storage/' . $game->hero_image) }}" alt="{{ $game->title }}"
                             class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-zinc-950/70"></div>
                    @elseif (isset($heroImages[$game->slug]))
                        <img src="{{ $heroImages[$game->slug] }}" alt="{{ $game->title }}"
                             class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-zinc-950/70"></div>
                    @else
                        <div class="absolute inset-0"
                             style="background:
                                radial-gradient(90% 90% at 18% 88%, {{ $game->accent_color }}4d 0%, transparent 55%),
                                linear-gradient(215deg, {{ $game->theme_color }} 0%, #09090b 72%);"></div>
                    @endif
                    <div class="bg-noise absolute inset-0 opacity-[0.05]"></div>

                    <div class="relative z-10 mx-auto max-w-5xl px-6 text-center">
                        <p class="text-xs font-bold uppercase tracking-[0.4em] text-cyan-400">
                            {{ $game->release_year ?? 'TBA' }} &middot; {{ $game->universe }} Universe
                        </p>
                        <h3 class="mt-5 font-display text-4xl uppercase leading-[0.95] neon-text sm:text-6xl lg:text-7xl">
                            {{ $game->title }}
                        </h3>
                        <p class="mx-auto mt-6 max-w-2xl leading-relaxed text-zinc-300">
                            {{ \Illuminate\Support\Str::limit($game->description, 190) }}
                        </p>
                        <a href="{{ route('games.show', $game) }}" class="btn-ghost mt-9 inline-flex">Lihat Detail</a>
                    </div>
                </article>
            @endforeach

            {{-- Indikator progres di sisi kanan --}}
            <div class="absolute right-6 top-1/2 z-20 hidden -translate-y-1/2 flex-col gap-3 sm:flex">
                @foreach ($featuredGames as $i => $game)
                    <span class="journey-dot {{ $i === 0 ? 'is-active' : '' }}" title="{{ $game->title }}"></span>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- ==================================================================
     3. COUNTDOWN GTA VI
================================================================== --}}
@php $upcoming = $featuredGames->firstWhere('status', 'upcoming'); @endphp
@if ($upcoming && $upcoming->release_date?->isFuture())
    <section class="relative border-y border-cyan-500/15 overflow-hidden">
        {{-- Animated gradient background --}}
        <div class="absolute inset-0 animated-gradient opacity-50"></div>
        <div class="bg-noise absolute inset-0 opacity-[0.04]"></div>

        <div class="relative z-10 mx-auto flex max-w-7xl flex-col items-center gap-6 px-6 py-14 md:flex-row md:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Hitung Mundur</p>
                <h2 class="mt-2 font-display text-3xl uppercase neon-text sm:text-4xl">{{ $upcoming->title }}</h2>
                <p class="mt-1 text-sm text-zinc-400">Rilis {{ $upcoming->release_date->format('d F Y') }} &middot; {{ $upcoming->platforms }}</p>
            </div>
            <div id="countdown" class="grid grid-cols-4 gap-3 text-center"
                 data-release="{{ $upcoming->release_date->startOfDay()->toIso8601String() }}">
                @foreach (['Hari' => 'cd-days', 'Jam' => 'cd-hours', 'Menit' => 'cd-mins', 'Detik' => 'cd-secs'] as $label => $id)
                    <div class="countdown-box min-w-[72px]">
                        <p id="{{ $id }}" class="font-display text-3xl text-cyan-400 neon-text">0</p>
                        <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-zinc-500">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- Neon section divider --}}
<div class="section-divider my-0"></div>

{{-- ==================================================================
     4. KATALOG GAME PER UNIVERSE
================================================================== --}}
<section class="mx-auto max-w-7xl px-6 py-24">
    <div class="reveal mb-14 max-w-2xl">
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Katalog</p>
        <h2 class="mt-3 font-display text-4xl uppercase sm:text-5xl">Dua Semesta, <span class="text-gta-accent">Satu Warisan</span></h2>
        <p class="mt-4 text-zinc-400">Jelajahi seluruh entri Grand Theft Auto — dari era klasik 3D Universe hingga era modern HD Universe.</p>
    </div>

    @foreach ([
        ['label' => '3D Universe', 'desc' => 'Era klasik 2001–2006: Liberty City, Vice City, dan San Andreas.', 'games' => $threeDGames],
        ['label' => 'HD Universe', 'desc' => 'Era modern 2008–sekarang: realisme, multi-protagonis, dan Leonida.', 'games' => $hdGames],
    ] as $group)
        <div class="mb-16 last:mb-0">
            <div class="reveal mb-7 flex items-end justify-between border-b border-cyan-500/15 pb-4">
                <div>
                    <h3 class="font-display text-2xl uppercase text-zinc-100">{{ $group['label'] }}</h3>
                    <p class="mt-1 text-sm text-zinc-500">{{ $group['desc'] }}</p>
                </div>
                <a href="{{ route('games.index', ['universe' => explode(' ', $group['label'])[0]]) }}"
                   class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:text-cyan-300 transition">Lihat Semua &rarr;</a>
            </div>

            <div class="grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($group['games'] as $game)
                    @include('games._card', ['game' => $game])
                @endforeach
            </div>
        </div>
    @endforeach
</section>

{{-- Neon section divider --}}
<div class="section-divider"></div>

{{-- ==================================================================
     5. ARTIKEL TERBARU
================================================================== --}}
<section class="border-t border-cyan-500/10 bg-zinc-900/30">
    <div class="mx-auto max-w-7xl px-6 py-24">
        <div class="reveal mb-12 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Redaksi</p>
                <h2 class="mt-3 font-display text-4xl uppercase sm:text-5xl">Artikel <span class="text-gta-accent">Terbaru</span></h2>
            </div>
            <a href="{{ route('articles.index') }}" class="btn-ghost">Semua Artikel</a>
        </div>

        @if ($headline)
            <a href="{{ route('articles.show', $headline) }}"
               class="reveal group mb-10 grid overflow-hidden rounded-3xl border border-white/10 bg-zinc-900/70 md:grid-cols-2 transition hover:border-cyan-500/30 hover:shadow-[0_0_30px_rgba(34,211,238,0.08)]">
                <div class="relative aspect-video min-h-[240px] overflow-hidden md:aspect-auto">
                    @if ($headline->featured_image)
                        <img src="{{ asset('storage/' . $headline->featured_image) }}" alt="{{ $headline->title }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @else
                        <img src="{{ $articleImages[0] }}" alt="{{ $headline->title }}"
                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                    @endif
                    <span class="absolute left-4 top-4 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest" style="background: linear-gradient(135deg, #0891b2, #ec4899);">Headline</span>
                </div>
                <div class="flex flex-col justify-center p-8">
                    <p class="text-xs text-zinc-500">
                        {{ $headline->category?->name ?? 'Umum' }} &middot; {{ $headline->published_at->format('d M Y') }}
                    </p>
                    <h3 class="mt-3 text-2xl font-extrabold leading-snug group-hover:text-cyan-400 transition sm:text-3xl">{{ $headline->title }}</h3>
                    <p class="mt-4 line-clamp-3 text-zinc-400">{{ $headline->excerpt }}</p>
                    <span class="mt-6 text-xs font-bold uppercase tracking-widest text-cyan-400">Baca Selengkapnya &rarr;</span>
                </div>
            </a>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($latestArticles as $article)
                @include('articles._card', ['article' => $article])
            @endforeach
        </div>
    </div>
</section>

{{-- ==================================================================
     6. TEASER KARAKTER
================================================================== --}}
<section class="mx-auto max-w-7xl px-6 py-24">
    <div class="reveal mb-12 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Ensiklopedia</p>
            <h2 class="mt-3 font-display text-4xl uppercase sm:text-5xl">Para <span class="text-gta-accent">Protagonis</span></h2>
            <p class="mt-3 max-w-xl text-zinc-400">Kenali tokoh utama dari setiap era — dari Claude yang membisu hingga duo Jason &amp; Lucia.</p>
        </div>
        <a href="{{ route('characters.index') }}" class="btn-ghost">Semua Karakter</a>
    </div>

    <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($protagonists as $character)
            @include('characters._card', ['character' => $character])
        @endforeach
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ---------------------------------------------------------
       HERO SLIDER — otomatis tiap 6 detik + navigasi manual
    --------------------------------------------------------- */
    const slides = Array.from(document.querySelectorAll('.hero-slide'));
    const dots = Array.from(document.querySelectorAll('.hero-dot'));
    const progress = document.getElementById('hero-progress');
    const DURATION = 6000;
    let current = 0;
    let timer = null;

    const animateSlideContent = (slide) => {
        if (!window.gsap) return;
        gsap.fromTo(slide.querySelectorAll('.hero-el'),
            { opacity: 0, y: 36 },
            { opacity: 1, y: 0, duration: 0.9, stagger: 0.12, ease: 'power3.out' });
    };

    const goTo = (index) => {
        if (!slides.length) return;
        current = (index + slides.length) % slides.length;
        slides.forEach((s, i) => s.classList.toggle('is-active', i === current));
        dots.forEach((d, i) => d.classList.toggle('is-active', i === current));
        animateSlideContent(slides[current]);
        restartProgress();
    };

    const restartProgress = () => {
        clearTimeout(timer);
        if (progress && window.gsap) {
            gsap.fromTo(progress, { width: '0%' }, { width: '100%', duration: DURATION / 1000, ease: 'none' });
        }
        timer = setTimeout(() => goTo(current + 1), DURATION);
    };

    if (slides.length) {
        animateSlideContent(slides[0]);
        if (slides.length > 1) restartProgress();
        document.getElementById('hero-next')?.addEventListener('click', () => goTo(current + 1));
        document.getElementById('hero-prev')?.addEventListener('click', () => goTo(current - 1));
        dots.forEach((d) => d.addEventListener('click', () => goTo(parseInt(d.dataset.goto, 10))));
    }

    /* ---------------------------------------------------------
       SCROLL JOURNEY — panel game berganti mengikuti gulir
    --------------------------------------------------------- */
    const panels = window.gsap ? gsap.utils.toArray('.journey-panel') : [];
    const journeyDots = Array.from(document.querySelectorAll('.journey-dot'));

    if (panels.length > 1) {
        gsap.set(panels, { autoAlpha: 0, scale: 1.08 });
        gsap.set(panels[0], { autoAlpha: 1, scale: 1 });

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: '#journey',
                start: 'top top',
                end: 'bottom bottom',
                scrub: 0.6,
                onUpdate: (self) => {
                    const idx = Math.min(panels.length - 1, Math.round(self.progress * (panels.length - 1)));
                    journeyDots.forEach((d, i) => d.classList.toggle('is-active', i === idx));
                },
            },
        });

        panels.forEach((panel, i) => {
            if (i === 0) return;
            tl.to(panels[i - 1], { autoAlpha: 0, scale: 0.96, duration: 1, ease: 'none' })
              .to(panel, { autoAlpha: 1, scale: 1, duration: 1, ease: 'none' }, '<0.25');
        });
    }

    /* ---------------------------------------------------------
       COUNTDOWN RILIS
    --------------------------------------------------------- */
    const cd = document.getElementById('countdown');
    if (cd) {
        const target = new Date(cd.dataset.release).getTime();
        const el = (id) => document.getElementById(id);
        const tick = () => {
            const diff = Math.max(0, target - Date.now());
            el('cd-days').textContent = Math.floor(diff / 86400000);
            el('cd-hours').textContent = Math.floor((diff % 86400000) / 3600000);
            el('cd-mins').textContent = Math.floor((diff % 3600000) / 60000);
            el('cd-secs').textContent = Math.floor((diff % 60000) / 1000);
        };
        tick();
        setInterval(tick, 1000);
    }
});
</script>
@endpush
