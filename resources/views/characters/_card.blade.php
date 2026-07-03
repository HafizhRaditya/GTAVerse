<a href="{{ route('characters.show', $character) }}"
   class="reveal group card-gta">
    <div class="relative flex h-48 items-center justify-center overflow-hidden"
         style="background: linear-gradient(160deg, {{ $character->game?->theme_color ?? '#27272a' }}, #09090b 85%);">
        @if ($character->photo)
            <img src="{{ asset('storage/' . $character->photo) }}" alt="{{ $character->name }}"
                 class="h-full w-full object-cover object-top transition duration-500 group-hover:scale-105">
        @else
            <span class="font-display text-5xl uppercase text-white/80 transition duration-500 group-hover:scale-110 group-hover:text-cyan-400/90">{{ $character->initials }}</span>
        @endif
        {{-- Overlay gradient from bottom --}}
        <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-zinc-900/90 to-transparent"></div>
    </div>
    <div class="p-4">
        <h3 class="font-bold leading-snug group-hover:text-cyan-400 transition">{{ $character->name }}</h3>
        <p class="mt-1 text-xs text-zinc-500">{{ $character->game?->title }}</p>
    </div>
</a>
