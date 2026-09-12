<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:160'],
            'email'   => ['required', 'email', 'max:160'],
            'year'    => ['nullable', 'string', 'max:20'],
            'topic'   => ['nullable', 'string', 'max:60'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        ContactMessage::create($data);

        return back()->with('status', 'Thank you — your message has been sent to the Secretary. We will reply by email, usually within a few days.');
    }
}
