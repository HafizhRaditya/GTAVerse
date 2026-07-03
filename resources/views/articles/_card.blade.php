@php
    $articleImages = ['/images/article-placeholder-1.png', '/images/article-placeholder-2.png'];
    $imgIdx = crc32($article->slug ?? $article->id ?? '') % count($articleImages);
@endphp

<a href="{{ route('articles.show', $article) }}"
   class="reveal group card-gta">
    <div class="relative h-44 overflow-hidden">
        @if ($article->featured_image)
            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <img src="{{ $articleImages[$imgIdx] }}" alt="{{ $article->title }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @endif
        @if ($article->category)
            <span class="absolute left-3 top-3 rounded-full bg-zinc-950/70 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-cyan-400 backdrop-blur">
                {{ $article->category->name }}
            </span>
        @endif
    </div>
    <div class="p-5">
        <p class="text-xs text-zinc-500">
            {{ $article->published_at?->format('d M Y') }}
            &middot; {{ $article->reading_time }} mnt baca
            &middot; {{ number_format($article->views, 0, ',', '.') }}x dibaca
        </p>
        <h3 class="mt-2 line-clamp-2 font-bold leading-snug group-hover:text-cyan-400 transition">{{ $article->title }}</h3>
        <p class="mt-2 line-clamp-2 text-sm text-zinc-400">{{ $article->excerpt }}</p>
    </div>
</a>
