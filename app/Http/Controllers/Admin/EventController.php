<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('admin.events.index', [
            'upcoming' => Event::upcoming()->get(),
            'past'     => Event::past()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event(['date' => now()->addWeek()])]);
    }

    public function store(Request $request)
    {
        Event::create($this->validated($request));

        return redirect()->route('admin.events.index')->with('status', 'Event added.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.form', ['event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->validated($request));

        return redirect()->route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'date'        => ['required', 'date'],
            'location'    => ['nullable', 'string', 'max:160'],
            'time'        => ['nullable', 'string', 'max:60'],
            'description' => ['nullable', 'string', 'max:600'],
            'sort'        => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
