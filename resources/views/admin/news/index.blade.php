@extends('admin.layout')
@section('title', 'News')
@section('heading', 'News')
@section('subheading', 'Articles shown on the News & Events page and the home page.')
@section('actions')
    <a href="{{ route('admin.news.create') }}" class="btn btn--primary">+ New article</a>
@endsection

@section('content')
    <div class="panel">
        @if ($articles->isEmpty())
            <p class="muted">No articles yet. <a href="{{ route('admin.news.create') }}">Write the first one</a>.</p>
        @else
            <div class="table-scroll">
                <table class="table">
                    <thead>
                        <tr><th>Date</th><th>Title</th><th>Tag</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                    @foreach ($articles as $a)
                        <tr>
                            <td class="muted">{{ $a->published_at?->format('j M Y') ?? '—' }}</td>
                            <td><a href="{{ route('admin.news.edit', $a) }}"><strong>{{ $a->title }}</strong></a><br><span class="muted">/{{ $a->slug }}</span></td>
                            <td>@if ($a->tag)<span class="pill">{{ $a->tag }}</span>@endif</td>
                            <td>
                                @if ($a->published_at && $a->published_at->isPast())
                                    <span class="pill">Live</span>
                                @else
                                    <span class="pill pill--muted">{{ $a->published_at ? 'Scheduled' : 'Draft' }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.news.edit', $a) }}" class="btn btn--ghost btn--sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.news.destroy', $a) }}" class="inline-form"
                                          onsubmit="return confirm('Delete this article?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn--danger btn--sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
