<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = Message::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('name', 'like', '%'.$request->q.'%')
                        ->orWhere('subject', 'like', '%'.$request->q.'%')
                        ->orWhere('body', 'like', '%'.$request->q.'%');
                });
            })
            ->when($request->status === 'unread', fn ($q) => $q->where('is_read', false))
            ->when($request->status === 'read', fn ($q) => $q->where('is_read', true))
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message): View
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function toggle(Message $message): RedirectResponse
    {
        $message->update(['is_read' => ! $message->is_read]);

        // Saat ditandai belum dibaca, kembali ke daftar — halaman detail
        // akan otomatis menandainya dibaca lagi jika dibuka ulang.
        return $message->is_read
            ? back()->with('success', 'Pesan ditandai sudah dibaca.')
            : redirect()->route('admin.messages.index')->with('success', 'Pesan ditandai belum dibaca.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
