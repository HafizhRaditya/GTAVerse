@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex items-center justify-between gap-4">
        <p class="text-xs text-zinc-500">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </p>

        <div class="flex items-center gap-1.5">
            {{-- Tombol sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-full border border-white/10 text-zinc-600">&lsaquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded-full border border-cyan-500/30 text-cyan-400 transition hover:bg-cyan-500/15">&lsaquo;</a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-1 text-zinc-600">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="flex h-8 min-w-8 items-center justify-center rounded-full px-2 text-xs font-bold text-white"
                                  style="background: linear-gradient(135deg, #0891b2, #ec4899); box-shadow: 0 0 12px rgba(34,211,238,0.25);">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="flex h-8 min-w-8 items-center justify-center rounded-full border border-white/10 px-2 text-xs text-zinc-300 transition hover:border-cyan-500/40 hover:text-cyan-400">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol berikutnya --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex h-8 w-8 items-center justify-center rounded-full border border-cyan-500/30 text-cyan-400 transition hover:bg-cyan-500/15">&rsaquo;</a>
            @else
                <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-full border border-white/10 text-zinc-600">&rsaquo;</span>
            @endif
        </div>
    </nav>
@endif
