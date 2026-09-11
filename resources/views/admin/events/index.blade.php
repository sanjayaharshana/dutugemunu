@extends('admin.layout')
@section('title', 'Events')
@section('heading', 'Events')
@section('subheading', 'Anything dated today or later shows under “Upcoming”; older dates move to “Recently”.')
@section('actions')
    <a href="{{ route('admin.events.create') }}" class="btn btn--primary">+ New event</a>
@endsection

@section('content')
    @foreach (['Upcoming' => $upcoming, 'Recently (past)' => $past] as $label => $list)
        <div class="panel">
            <h2>{{ $label }}</h2>
            @if ($list->isEmpty())
                <p class="muted">Nothing here.</p>
            @else
                <table class="table">
                    <thead><tr><th>Date</th><th>Event</th><th>Where</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($list as $e)
                        <tr>
                            <td class="muted">{{ $e->date->format('j M Y') }}</td>
                            <td><a href="{{ route('admin.events.edit', $e) }}"><strong>{{ $e->title }}</strong></a></td>
                            <td class="muted">{{ $e->location }}{{ $e->time ? ' · ' . $e->time : '' }}</td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.events.edit', $e) }}" class="btn btn--ghost btn--sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $e) }}" class="inline-form"
                                          onsubmit="return confirm('Delete this event?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn--danger btn--sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endforeach
@endsection
