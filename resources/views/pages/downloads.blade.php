@extends('layouts.app')

@section('title', 'Downloads')
@section('meta_description', 'Download the Dutugemunu College Old Students\' Association constitution and the membership application form.')

@section('content')

@include('partials.page-hero', [
    'title'    => 'Downloads',
    'crumb'    => 'Downloads',
    'subtitle' => 'Official documents of the Association — the constitution and the membership application form.',
])

<section class="section section--cream">
    <div class="wrap wrap--narrow">
        @if ($downloads->isEmpty())
            <p class="muted">No documents have been published yet.</p>
        @else
            <div class="grid grid--2">
                @foreach ($downloads as $doc)
                    <div class="qa-card reveal">
                        <div class="qa-card__icon">
                            <svg viewBox="0 0 24 24"><path d="M6 2.5h9l4.5 4.5V21a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1z"/><path d="M14.5 2.5V8h4.5"/><path d="M8.5 13h7M8.5 16.5h7M8.5 9.5h3"/></svg>
                        </div>
                        <h3>{{ $doc['title'] }}</h3>
                        <p>{{ $doc['description'] }}</p>

                        @if ($doc['exists'])
                            <p class="muted" style="font-size:.85rem;margin-bottom:1rem">PDF{{ $doc['size_label'] ? ' · ' . $doc['size_label'] : '' }}</p>
                            <a href="{{ $doc['url'] }}" class="btn btn--primary" target="_blank" rel="noopener">Download PDF</a>
                        @else
                            <p class="muted" style="font-size:.85rem">This document isn't available right now — please contact the Secretary.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
