@extends('admin.layout')
@section('title', $message->name)
@section('heading', $message->name)
@section('subheading', 'Sent ' . $message->created_at->format('j F Y, g:ia') . ' · ' . $message->email)
@section('actions')
    <a href="{{ route('admin.messages.index') }}" class="btn btn--ghost">&larr; All messages</a>
@endsection

@section('content')
    <div class="panel">
        <div class="form-grid">
            <div class="field"><label>From</label><p>{{ $message->name }}</p></div>
            <div class="field"><label>Email</label><p><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p></div>
            <div class="field"><label>Year left <span class="hint">(if an old student)</span></label><p>{{ $message->year ?: '—' }}</p></div>
            <div class="field"><label>Topic</label><p>{{ $message->topic ?: '—' }}</p></div>
            <div class="field field--full">
                <label>Message</label>
                <p style="white-space:pre-line">{{ $message->message }}</p>
            </div>
        </div>

        <div class="form-actions">
            <a href="mailto:{{ $message->email }}?subject=Re:%20Your%20message%20to%20the%20Association" class="btn btn--primary">Reply by email</a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                  onsubmit="return confirm('Delete this message? This cannot be undone.')">
                @csrf @method('DELETE')
                <button class="btn btn--danger">Delete this message</button>
            </form>
        </div>
    </div>
@endsection
