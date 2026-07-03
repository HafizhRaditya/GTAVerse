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

<a href="{{ route('games.show', $game) }}"
   class="reveal group card-gta">
    <div class="relative aspect-[3/4] overflow-hidden">
        @if ($game->cover_image)
            <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @elseif (isset($heroImages[$game->slug]))
            <img src="{{ $heroImages[$game->slug] }}" alt="{{ $game->title }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center transition duration-500 group-hover:scale-105"
                 style="background: linear-gradient(135deg, {{ $game->theme_color }}, #09090b 90%);">
                <span class="px-4 text-center font-display text-2xl uppercase leading-tight text-white/90">{{ $game->title }}</span>
            </div>
        @endif
        <span class="absolute right-3 top-3 rounded-full bg-zinc-950/70 px-3 py-1 text-[10px] font-bold uppercase tracking-widest backdrop-blur"
              style="color: {{ $game->accent_color }}">{{ $game->universe }}</span>
        @if ($game->status === 'upcoming')
            <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-widest pulse-glow"
                  style="background: linear-gradient(135deg, #0891b2, #ec4899);">Segera</span>
        @endif
    </div>
    <div class="p-5">
        <p class="text-xs text-zinc-500">{{ $game->release_year ?? 'TBA' }} &middot; {{ $game->setting }}</p>
        <h4 class="mt-1 text-lg font-bold group-hover:text-cyan-400 transition">{{ $game->title }}</h4>
        <p class="mt-2 line-clamp-2 text-sm text-zinc-400">{{ $game->tagline }}</p>
    </div>
</a>
