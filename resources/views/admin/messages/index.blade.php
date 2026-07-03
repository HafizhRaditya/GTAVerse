@extends('admin.layouts.admin')

@section('title', 'Kotak Saran')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Kotak <span class="text-gta-accent">Saran</span></h1>
            <p class="mt-2 text-sm text-zinc-400">Saran dan masukan yang dikirim pengunjung melalui halaman Kotak Saran.</p>
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / subjek / isi pesan…" class="form-input max-w-xs">
        <select name="status" class="form-input w-auto">
            <option value="">Semua Pesan</option>
            <option value="unread" @selected(request('status') === 'unread')>Belum Dibaca</option>
            <option value="read" @selected(request('status') === 'read')>Sudah Dibaca</option>
        </select>
        <button type="submit" class="btn-ghost !px-5 !py-2.5">Cari</button>
    </form>

    <div class="glass-panel overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Pengirim</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Waktu</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'bg-cyan-500/[0.04]' }}">
                        <td>
                            <span class="badge-admin {{ $message->is_read ? 'badge-gray' : 'badge-pink' }}">
                                {{ $message->is_read ? 'Dibaca' : 'Baru' }}
                            </span>
                        </td>
                        <td>
                            <span class="{{ $message->is_read ? 'font-medium' : 'font-bold' }}">{{ $message->name }}</span>
                            @if ($message->email)
                                <span class="block text-xs text-zinc-500">{{ $message->email }}</span>
                            @endif
                        </td>
                        <td class="text-zinc-300">{{ $message->subject ?? '—' }}</td>
                        <td class="max-w-xs text-zinc-400">{{ Str::limit($message->body, 60) }}</td>
                        <td class="whitespace-nowrap text-zinc-400">{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn-admin-sm btn-edit">Baca</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                                      onsubmit="return confirm('Hapus pesan dari \'{{ addslashes($message->name) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 text-center text-zinc-500">Belum ada saran yang masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $messages->links('admin.partials.pagination') }}</div>
@endsection
