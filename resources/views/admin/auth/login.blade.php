<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — GTAVerse Admin</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=anton:400|inter:400,500,600,700,800" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body class="bg-zinc-950 font-sans text-zinc-100 antialiased selection:bg-cyan-500/40">

    <div class="animated-gradient relative flex min-h-screen items-center justify-center overflow-hidden px-4">
        <div class="bg-noise pointer-events-none absolute inset-0 opacity-20"></div>

        <div class="glass-panel relative z-10 w-full max-w-md p-8 sm:p-10">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="font-display text-3xl uppercase tracking-wide">
                    GTA<span class="text-gta-accent">Verse</span>
                </a>
                <p class="mt-2 text-[11px] font-bold uppercase tracking-[0.3em] text-cyan-400/70">Admin Panel</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-pink-500/30 bg-pink-500/10 px-4 py-3 text-sm text-pink-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-300/70">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl border border-white/10 bg-zinc-900/70 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition focus:border-cyan-500/60 focus:outline-none focus:ring-1 focus:ring-cyan-500/40"
                           placeholder="admin@gtaverse.test">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-300/70">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-xl border border-white/10 bg-zinc-900/70 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition focus:border-cyan-500/60 focus:outline-none focus:ring-1 focus:ring-cyan-500/40"
                           placeholder="••••••••">
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-400">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-white/20 bg-zinc-900 accent-cyan-500">
                    Remember me
                </label>

                <button type="submit" class="btn-primary w-full">Sign In to Panel</button>
            </form>

            <p class="mt-6 text-center text-xs text-zinc-500">
                <a href="{{ route('home') }}" class="transition hover:text-cyan-400">&larr; Back to home</a>
            </p>
        </div>
    </div>

</body>
</html>
