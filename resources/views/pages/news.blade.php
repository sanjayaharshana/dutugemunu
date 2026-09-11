@extends('layouts.app')

@section('title', 'News & Events')
@section('meta_description', 'Announcements, project updates and the events calendar of the Dutugemunu College Old Boys\' Association, Buttala.')

@section('content')

@include('partials.page-hero', [
    'title'    => 'News & Events',
    'crumb'    => 'News & Events',
    'subtitle' => 'What the Association has been doing, and what is coming up in the diary.',
])

{{-- News --}}
<section class="section section--cream">
    <div class="wrap">
        <div class="section-head">
            <p class="eyebrow">Latest news</p>
            <h2>Announcements &amp; updates</h2>
        </div>
        <div class="grid grid--3">
            @foreach ($news as $item)
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
                        <p>{{ $item['excerpt'] }}</p>
                        <a href="{{ route('news.show', $item['slug']) }}" class="textlink">Read the full story</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Upcoming events --}}
<section class="section section--paper" id="events">
    <div class="wrap wrap--narrow">
        <div class="section-head">
            <p class="eyebrow">The diary</p>
            <h2>Upcoming events</h2>
            <p>Members are notified by email and through the branch secretaries before each event. Save the dates.</p>
        </div>
        <ul class="events reveal">
            @foreach ($events as $ev)
                <li class="event">
                    <div class="event__date">
                        <span class="d">{{ $ev['date']->format('d') }}</span>
                        <span class="m">{{ $ev['date']->format('M') }}</span>
                        <span class="y">{{ $ev['date']->format('Y') }}</span>
                    </div>
                    <div class="event__body">
                        <h3>{{ $ev['title'] }}</h3>
                        <div class="event__where">
                            <span>&#128205; {{ $ev['location'] }}</span>
                            <span>&#128337; {{ $ev['time'] }}</span>
                        </div>
                        <p>{{ $ev['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- Past events --}}
<section class="section section--sand">
    <div class="wrap wrap--narrow">
        <div class="section-head">
            <p class="eyebrow">Recently</p>
            <h2>In the rear-view mirror</h2>
        </div>
        <ul class="events reveal">
            @foreach ($pastEvents as $ev)
                @php($d = \Illuminate\Support\Carbon::parse($ev['date']))
                <li class="event">
                    <div class="event__date" style="background:var(--muted)">
                        <span class="d">{{ $d->format('d') }}</span>
                        <span class="m">{{ $d->format('M') }}</span>
                        <span class="y">{{ $d->format('Y') }}</span>
                    </div>
                    <div class="event__body">
                        <h3>{{ $ev['title'] }}</h3>
                        <p>{{ $ev['text'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- Submit --}}
<section class="section cta-band">
    <div class="wrap">
        <h2>Have something to share?</h2>
        <p>Branch news, an achievement, a milestone, a call for volunteers &mdash; send it to the Editor and we will feature it here and in the newsletter.</p>
        <div class="hero__actions">
            <a href="{{ route('contact') }}" class="btn btn--light">Submit an item</a>
        </div>
    </div>
</section>

@endsection
