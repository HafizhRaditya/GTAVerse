@extends('admin.layouts.admin')

@section('title', 'Suggestion Inbox')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Suggestion <span class="text-gta-accent">Inbox</span></h1>
            <p class="mt-2 text-sm text-zinc-400">Suggestions and feedback sent by visitors through the Suggestion Box page.</p>
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name / subject / message…" class="form-input max-w-xs">
        <select name="status" class="form-input w-auto">
            <option value="">All Messages</option>
            <option value="unread" @selected(request('status') === 'unread')>Unread</option>
            <option value="read" @selected(request('status') === 'read')>Read</option>
        </select>
        <button type="submit" class="btn-ghost !px-5 !py-2.5">Search</button>
    </form>

    <div class="glass-panel overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Sent</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'bg-cyan-500/[0.04]' }}">
                        <td>
                            <span class="badge-admin {{ $message->is_read ? 'badge-gray' : 'badge-pink' }}">
                                {{ $message->is_read ? 'Read' : 'New' }}
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
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn-admin-sm btn-edit">Read</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                                      onsubmit="return confirm('Delete the message from \'{{ addslashes($message->name) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 text-center text-zinc-500">No suggestions have come in yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $messages->links('admin.partials.pagination') }}</div>
@endsection
