<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GTAVerse — Grand Theft Auto News Portal')</title>
    <meta name="description" content="@yield('meta_description', 'News, game catalog, and Grand Theft Auto character profiles from the 3D Universe to the HD Universe.')">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=anton:400|inter:400,500,600,700,800" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 font-sans text-zinc-100 antialiased selection:bg-cyan-500/40">

    {{-- ============================ NAVBAR ============================ --}}
    <header id="navbar" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="{{ route('home') }}" class="group font-display text-2xl uppercase tracking-wide">
                GTA<span class="text-gta-accent">Verse</span>
            </a>

            <div class="hidden items-center gap-7 text-xs font-bold uppercase tracking-[0.2em] md:flex">
                <a href="{{ route('home') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('home') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Home</a>
                <a href="{{ route('games.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('games.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Games</a>
                <a href="{{ route('articles.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('articles.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Articles</a>
                <a href="{{ route('characters.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('characters.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Characters</a>
                <a href="{{ route('messages.create') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('messages.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Feedback</a>
                <a href="/admin" class="rounded-full border border-cyan-500/50 px-4 py-1.5 text-cyan-400 transition hover:bg-cyan-500/15 hover:shadow-[0_0_15px_rgba(34,211,238,0.25)]">Admin</a>
            </div>

            <button id="menu-btn" class="text-zinc-200 md:hidden" aria-label="Open menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </nav>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden border-t border-cyan-500/15 bg-zinc-950/95 backdrop-blur-xl md:hidden">
            <div class="flex flex-col gap-1 px-6 py-4 text-sm font-bold uppercase tracking-widest">
                <a href="{{ route('home') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Home</a>
                <a href="{{ route('games.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Games</a>
                <a href="{{ route('articles.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Articles</a>
                <a href="{{ route('characters.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Characters</a>
                <a href="{{ route('messages.create') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Suggestion Box</a>
                <a href="/admin" class="py-2 text-cyan-400">Admin Panel</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- ============================ FOOTER ============================ --}}
    <footer class="relative border-t border-cyan-500/10 bg-zinc-950 overflow-hidden">
        {{-- Skyline background decoration --}}
        <div class="footer-skyline"></div>

        <div class="relative z-10 mx-auto grid max-w-7xl gap-10 px-6 py-14 md:grid-cols-3">
            <div>
                <p class="font-display text-2xl uppercase">GTA<span class="text-gta-accent">Verse</span></p>
                <p class="mt-3 max-w-xs text-sm leading-relaxed text-zinc-400">
                    News portal, game catalog, and Grand Theft Auto character encyclopedia —
                    from the 3D Universe to the HD Universe.
                </p>
                {{-- Social-style decoration --}}
                <div class="mt-5 flex gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-cyan-500/25 text-xs text-cyan-400 transition hover:bg-cyan-500/15 hover:shadow-[0_0_10px_rgba(34,211,238,0.2)] cursor-pointer">★</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-cyan-500/25 text-xs text-cyan-400 transition hover:bg-cyan-500/15 hover:shadow-[0_0_10px_rgba(34,211,238,0.2)] cursor-pointer">♦</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-cyan-500/25 text-xs text-cyan-400 transition hover:bg-cyan-500/15 hover:shadow-[0_0_10px_rgba(34,211,238,0.2)] cursor-pointer">▲</span>
                </div>
            </div>
            <div class="text-sm">
                <p class="mb-3 font-bold uppercase tracking-widest text-cyan-400/60">Explore</p>
                <ul class="space-y-2 text-zinc-300">
                    <li><a href="{{ route('games.index') }}" class="transition hover:text-cyan-400">All Games</a></li>
                    <li><a href="{{ route('articles.index') }}" class="transition hover:text-cyan-400">Articles &amp; News</a></li>
                    <li><a href="{{ route('characters.index') }}" class="transition hover:text-cyan-400">Character Profiles</a></li>
                    <li><a href="{{ route('messages.create') }}" class="transition hover:text-cyan-400">Suggestion Box</a></li>
                    <li><a href="/admin" class="transition hover:text-cyan-400">Admin Panel</a></li>
                </ul>
            </div>
            <div class="text-sm text-zinc-500">
                <p class="mb-3 font-bold uppercase tracking-widest text-cyan-400/60">Disclaimer</p>
                <p class="leading-relaxed">
                    GTAVerse is an unofficial fan portal. Grand Theft Auto and all related
                    trademarks and assets are the property of Rockstar Games &amp; Take-Two Interactive.
                </p>
            </div>
        </div>

        {{-- Neon divider --}}
        <div class="section-divider"></div>

        <div class="relative z-10 py-5 text-center text-xs text-zinc-600">
            &copy; {{ date('Y') }} GTA<span class="text-cyan-600">Verse</span> CMS — built with Laravel &amp; Tailwind CSS.
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
        // Navbar becomes solid when the page is scrolled
        const navbar = document.getElementById('navbar');
        const handleNavScroll = () => navbar.classList.toggle('nav-scrolled', window.scrollY > 40);
        handleNavScroll();
        window.addEventListener('scroll', handleNavScroll, { passive: true });

        // Mobile menu
        document.getElementById('menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Global reveal-on-scroll animation for .reveal elements
        if (window.gsap && window.ScrollTrigger) {
            gsap.registerPlugin(ScrollTrigger);

            ScrollTrigger.batch('.reveal', {
                start: 'top 88%',
                once: true,
                onEnter: (batch) => gsap.to(batch, {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: 'power3.out',
                }),
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
