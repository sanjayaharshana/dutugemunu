<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::orderByDesc('created_at')->get(),
        ]);
    }

    public function show(ContactMessage $message)
    {
        if (! $message->isRead()) {
            $message->read_at = now();
            $message->save();
        }

        return view('admin.messages.show', ['message' => $message]);
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('status', 'Message deleted.');
    }
}
