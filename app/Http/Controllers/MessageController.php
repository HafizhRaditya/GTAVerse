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
            'name.required' => 'Name is required.',
            'body.required' => 'A message or suggestion is required.',
            'email.email'   => 'The email format is invalid.',
        ]);

        Message::create($data);

        return redirect()->route('messages.create')
            ->with('success', 'Thank you! Your suggestion has been sent and we will read it.');
    }
}
