@extends('layouts.app')

@section('title', 'Kotak Saran — GTAVerse')
@section('meta_description', 'Sampaikan saran, kritik, atau masukan Anda untuk GTAVerse.')

@section('content')
<section class="mx-auto max-w-7xl px-6 pb-24 pt-36">
    <div class="reveal mx-auto max-w-2xl text-center">
        <p class="text-xs font-bold uppercase tracking-[0.3em] text-cyan-400">Masukan Anda</p>
        <h1 class="mt-3 font-display text-5xl uppercase sm:text-6xl">Kotak <span class="text-gta-accent">Saran</span></h1>
        <p class="mt-4 text-zinc-400">
            Punya saran, kritik, koreksi konten, atau ide fitur untuk GTAVerse?
            Tulis di sini — setiap pesan masuk langsung ke redaksi kami.
        </p>
    </div>

    <div class="reveal mx-auto mt-12 max-w-2xl">
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-teal-400/30 bg-teal-400/10 px-5 py-4 text-sm text-teal-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-pink-500/30 bg-pink-500/10 px-5 py-4 text-sm text-pink-200">
                <ul class="list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('messages.store') }}" class="glass-panel space-y-5 p-8">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-300/70">Nama *</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255"
                           class="w-full rounded-xl border border-white/10 bg-zinc-900/70 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition focus:border-cyan-500/60 focus:outline-none focus:ring-1 focus:ring-cyan-500/40"
                           placeholder="Nama kamu">
                </div>
                <div>
                    <label for="email" class="mb-1.5 block text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-300/70">Email <span class="normal-case text-zinc-500">(opsional)</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="255"
                           class="w-full rounded-xl border border-white/10 bg-zinc-900/70 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition focus:border-cyan-500/60 focus:outline-none focus:ring-1 focus:ring-cyan-500/40"
                           placeholder="email@contoh.com">
                </div>
            </div>

            <div>
                <label for="subject" class="mb-1.5 block text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-300/70">Subjek <span class="normal-case text-zinc-500">(opsional)</span></label>
                <input id="subject" type="text" name="subject" value="{{ old('subject') }}" maxlength="255"
                       class="w-full rounded-xl border border-white/10 bg-zinc-900/70 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition focus:border-cyan-500/60 focus:outline-none focus:ring-1 focus:ring-cyan-500/40"
                       placeholder="contoh: Saran fitur, koreksi artikel…">
            </div>

            <div>
                <label for="body" class="mb-1.5 block text-[11px] font-bold uppercase tracking-[0.2em] text-cyan-300/70">Pesan / Saran *</label>
                <textarea id="body" name="body" rows="6" required maxlength="5000"
                          class="w-full rounded-xl border border-white/10 bg-zinc-900/70 px-4 py-3 text-sm text-zinc-100 placeholder-zinc-600 transition focus:border-cyan-500/60 focus:outline-none focus:ring-1 focus:ring-cyan-500/40"
                          placeholder="Tulis saran atau masukanmu di sini…">{{ old('body') }}</textarea>
                <p class="mt-1.5 text-xs text-zinc-600">Maksimal 5.000 karakter.</p>
            </div>

            <button type="submit" class="btn-primary w-full sm:w-auto">Kirim Saran</button>
        </form>
    </div>
</section>
@endsection
