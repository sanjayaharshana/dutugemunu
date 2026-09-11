@extends('layouts.app')

@section('title', $article['title'])
@section('meta_description', $article['excerpt'])

@section('content')

@include('partials.page-hero', [
    'title'    => $article['tag'],
    'crumb'    => 'News',
])

<section class="section section--cream">
    <div class="wrap">
        <article class="article reveal">
            <p style="margin-bottom:1rem"><a href="{{ route('news') }}" style="font-weight:700;letter-spacing:.02em">&#8592;&nbsp;&nbsp;Back to all news</a></p>
            <h1 style="font-size:clamp(1.9rem,4vw,2.8rem)">{{ $article['title'] }}</h1>
            <div class="article__meta">
                <span class="tag">{{ $article['tag'] }}</span>
                <time datetime="{{ $article['date']->toDateString() }}">{{ $article['date']->format('l, j F Y') }}</time>
            </div>
            <div class="article__hero">
                <img src="{{ asset($article['image']) }}" alt="">
            </div>
            @foreach ($article['body'] as $para)
                <p>{{ $para }}</p>
            @endforeach

            <hr>
            <p style="color:var(--muted);font-size:.95rem">Issued by the Media &amp; Communications sub-committee. For more information contact
                <a href="mailto:{{ config('association.contact.email') }}">{{ config('association.contact.email') }}</a>.</p>
        </article>
    </div>
</section>

@if ($more->isNotEmpty())
<section class="section section--paper">
    <div class="wrap">
        <div class="section-head"><p class="eyebrow">Keep reading</p><h2>More from the Association</h2></div>
        <div class="grid grid--3">
            @foreach ($more as $item)
                <article class="card reveal">
                    <a href="{{ route('news.show', $item['slug']) }}" class="card__media">
                        <img src="{{ asset($item['image']) }}" alt="" loading="lazy">
                    </a>
                    <div class="card__body">
                        <div class="card__meta">
                            <span class="tag">{{ $item['tag'] }}</span>
                            <time datetime="{{ $item['date']->toDateString() }}">{{ $item['date']->format('j M Y') }}</time>
                        </div>
                        <h3><a href="{{ route('news.show', $item['slug']) }}">{{ $item['title'] }}</a></h3>
                        <a href="{{ route('news.show', $item['slug']) }}" class="textlink">Read more</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
