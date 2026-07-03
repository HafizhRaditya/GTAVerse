<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function create(): View
    {
        return view('messages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body'    => ['required', 'string', 'max:5000'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'body.required' => 'Pesan atau saran wajib diisi.',
            'email.email'   => 'Format email tidak valid.',
        ]);

        Message::create($data);

        return redirect()->route('messages.create')
            ->with('success', 'Terima kasih! Saran Anda telah terkirim dan akan kami baca.');
    }
}
