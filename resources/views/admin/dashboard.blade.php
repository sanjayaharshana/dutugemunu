@extends('admin.layout')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Manage the content that appears on the public website.')

@section('content')
    <div class="stat-grid mt">
        <a class="stat" href="{{ route('admin.committee.index') }}"><b>{{ $counts['office_bearers'] }}</b><span>Office bearers</span></a>
        <a class="stat" href="{{ route('admin.committee.index') }}"><b>{{ $counts['members'] }}</b><span>Committee members</span></a>
        <a class="stat" href="{{ route('admin.news.index') }}"><b>{{ $counts['news'] }}</b><span>News articles</span></a>
        <a class="stat" href="{{ route('admin.events.index') }}"><b>{{ $counts['events'] }}</b><span>Events</span></a>
        <a class="stat" href="{{ route('admin.media.index') }}"><b>{{ $counts['gallery'] }}</b><span>Gallery images</span></a>
        <a class="stat" href="{{ route('admin.media.index') }}"><b>{{ $counts['hero'] }}</b><span>Hero images</span></a>
        <a class="stat" href="{{ route('admin.funds.index') }}"><b>{{ $fundBalance }}</b><span>Fund balance</span></a>
    </div>

    <div class="panel">
        <div class="panel__head">
            <h2>Latest news</h2>
            <a href="{{ route('admin.news.create') }}" class="btn btn--ghost btn--sm">+ New article</a>
        </div>
        @if ($recentNews->isEmpty())
            <p class="muted">No articles yet.</p>
        @else
            <table class="table">
                <tbody>
                @foreach ($recentNews as $a)
                    <tr>
                        <td>{{ $a->published_at?->format('j M Y') ?? '—' }}</td>
                        <td><a href="{{ route('admin.news.edit', $a) }}">{{ $a->title }}</a></td>
                        <td>@if ($a->published_at && $a->published_at->isPast())<span class="pill">Live</span>@else<span class="pill pill--muted">Draft</span>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
