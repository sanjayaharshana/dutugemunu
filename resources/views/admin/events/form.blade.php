@extends('admin.layout')
@section('title', $event->exists ? 'Edit event' : 'New event')
@section('heading', $event->exists ? 'Edit event' : 'New event')

@section('content')
    <form class="panel" method="POST"
          action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}">
        @csrf
        @if ($event->exists) @method('PUT') @endif

        <div class="form-grid">
            <div class="field field--full">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required>
                @error('title')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="{{ old('date', optional($event->date)->format('Y-m-d')) }}" required>
                @error('date')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="time">Time <span class="hint">(free text, e.g. “7.00 p.m.”)</span></label>
                <input type="text" name="time" id="time" value="{{ old('time', $event->time) }}">
            </div>
            <div class="field field--full">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}">
            </div>
            <div class="field field--full">
                <label for="description">Description</label>
                <textarea name="description" id="description" style="min-height:90px">{{ old('description', $event->description) }}</textarea>
            </div>
            <div class="field">
                <label for="sort">Order <span class="hint">(lower shows first among upcoming)</span></label>
                <input type="number" name="sort" id="sort" min="0" value="{{ old('sort', $event->sort ?? 0) }}">
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn--primary">Save</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
@endsection
