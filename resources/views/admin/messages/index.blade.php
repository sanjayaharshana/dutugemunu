@extends('admin.layout')
@section('title', 'Messages')
@section('heading', 'Messages')
@section('subheading', 'Everything sent through the "Write to the Secretary" form on the Contact page.')

@section('content')
    <div class="panel">
        @if ($messages->isEmpty())
            <p class="muted">No messages yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr><th>Received</th><th>From</th><th>Topic</th><th>Status</th><th></th></tr>
                </thead>
                <tbody>
                @foreach ($messages as $m)
                    <tr>
                        <td class="muted">{{ $m->created_at->format('j M Y, g:ia') }}</td>
                        <td>
                            <a href="{{ route('admin.messages.show', $m) }}"><strong>{{ $m->name }}</strong></a>
                            <div class="muted" style="font-size:.82rem">{{ $m->email }}</div>
                        </td>
                        <td class="muted">{{ $m->topic ?: '—' }}</td>
                        <td>
                            @if ($m->isRead())
                                <span class="pill pill--muted">Read</span>
                            @else
                                <span class="pill">Unread</span>
                            @endif
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.messages.show', $m) }}" class="btn btn--ghost btn--sm">View</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" class="inline-form"
                                      onsubmit="return confirm('Delete this message?')">
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
@endsection
