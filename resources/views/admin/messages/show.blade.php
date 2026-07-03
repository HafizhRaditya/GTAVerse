@extends('admin.layouts.admin')

@section('title', 'Baca Saran')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:underline">&larr; Kembali ke Kotak Saran</a>
            <h1 class="mt-3 font-display text-3xl uppercase tracking-wide">{{ $message->subject ?? 'Tanpa Subjek' }}</h1>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="glass-panel p-7 lg:col-span-2">
            <p class="whitespace-pre-line leading-relaxed text-zinc-200">{{ $message->body }}</p>
        </div>

        <div class="space-y-6">
            <div class="glass-panel space-y-4 p-6">
                <h2 class="font-display text-lg uppercase tracking-wide text-cyan-300">Detail Pengirim</h2>
                <div>
                    <p class="form-label !mb-1">Nama</p>
                    <p class="text-zinc-100">{{ $message->name }}</p>
                </div>
                <div>
                    <p class="form-label !mb-1">Email</p>
                    @if ($message->email)
                        <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject ?? 'Saran Anda di GTAVerse') }}"
                           class="text-cyan-400 hover:underline">{{ $message->email }}</a>
                    @else
                        <p class="text-zinc-500">Tidak dicantumkan</p>
                    @endif
                </div>
                <div>
                    <p class="form-label !mb-1">Dikirim</p>
                    <p class="text-zinc-100">{{ $message->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                @if ($message->email)
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject ?? 'Saran Anda di GTAVerse') }}"
                       class="btn-primary">Balas via Email</a>
                @endif
                <form method="POST" action="{{ route('admin.messages.toggle', $message) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-ghost">Tandai Belum Dibaca</button>
                </form>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                      onsubmit="return confirm('Hapus pesan ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-admin-sm btn-delete !px-6 !py-3">Hapus Pesan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
