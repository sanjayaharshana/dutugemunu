@extends('layouts.app')

@section('title', config('association.name'))
@section('meta_description', 'The official website of the Dutugemunu College Old Students\' Association, Buttala. Reconnect with old friends, follow Association news and events, meet the committee and become a member.')

@php($cfg = config('association'))

@section('content')

{{-- ============================================================ Hero --}}
@php($heroShots = collect($cfg['hero'] ?? [])->filter()->values()->all())
@php($heroShots = $heroShots ?: ['hero/campus.webp', 'hero/avenue.webp', 'hero/shrine.webp', 'hero/road.webp'])
<section class="hero" aria-label="Welcome">
    <div class="hero__bg" aria-hidden="true">
        @foreach ($heroShots as $i => $img)
            <div class="hero__slide @if ($i === 0) is-active @endif"
                 style="background-image:url('{{ asset($img) }}')"></div>
        @endforeach
    </div>
    <div class="hero__wash" aria-hidden="true"></div>
    <div class="hero__tint" aria-hidden="true"></div>

    <div class="wrap">
        <div class="hero__grid">
            <div class="hero__inner">
                <p class="hero__kicker">Established {{ $cfg['oba_founded'] }} &nbsp;&bull;&nbsp; Buttala, Sri Lanka</p>
                <h1>Once a son of Dutugemunu, always a son of Dutugemunu.</h1>
                <p class="hero__motto">{{ $cfg['motto'] }} &nbsp;&mdash;&nbsp; <span lang="si">{{ $cfg['motto_si'] }}</span></p>
                <div class="hero__actions">
                    @auth('member')
                        <a href="{{ route('member.dashboard') }}" class="btn btn--light">Dashboard</a>
                    @else
                        <a href="{{ route('join') }}" class="btn btn--light">Become a Member</a>
                    @endauth
                    <a href="{{ route('about') }}" class="btn btn--ondark">Our Story</a>
                </div>
            </div>

            <div class="hero__art" aria-hidden="true">
                <span class="hero__art-ring"></span>
                <span class="hero__art-dots"></span>
                <svg class="hero__art-arc" viewBox="0 0 120 120" fill="none">
                    <path d="M8 96 A 78 78 0 0 1 112 22" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                </svg>
                <div class="hero__blob">
                    @foreach ($heroShots as $i => $img)
                        <img src="{{ asset($img) }}" alt=""
                             class="hero__artshot @if ($i === 0) is-active @endif"
                             loading="lazy" width="1360" height="1020">
                    @endforeach
                </div>
                <span class="hero__art-disc"></span>
            </div>
        </div>
    </div>

    <div class="hero__dots" role="tablist" aria-label="Choose hero image">
        @foreach ($heroShots as $i => $img)
            <button type="button" class="@if ($i === 0) is-active @endif" aria-label="Image {{ $i + 1 }}"></button>
        @endforeach
    </div>

    <a href="#welcome" class="hero__scroll" aria-label="Scroll to content">
        <span>Scroll</span>
        <span class="hero__scroll-chev" aria-hidden="true"></span>
    </a>
</section>

{{-- ============================================================ Welcome --}}
<section class="section section--cream" id="welcome">
    <div class="wrap">
        <div class="split">
            <div class="reveal">
                <p class="eyebrow">Welcome</p>
                <h2>The bond that outlasts the school bell</h2>
                <p class="lead">The school in Buttala opened its doors in {{ $cfg['founded'] }}. The Old Students' Association was formed in {{ $cfg['oba_founded'] }} to keep that fellowship alive and to stand behind the growing college.</p>
                <p>More than fifty years on, we are over {{ $cfg['stats'][2]['value'] }} members &mdash; farmers and physicians, teachers and public servants &mdash; with chapters in Colombo and overseas. What unites us is simple: a debt of gratitude to the school that made us, and a determination to pay it forward to the students who sit in our old classrooms today.</p>
                <a href="{{ route('about') }}" class="textlink">Read our full story</a>
            </div>
            <div class="reveal media-offset">
                <div class="figure-frame figure-frame--offset figure-frame--wide">
                    <img src="{{ asset('dcc_national_school.jpg') }}" alt="The main building at Dutugemunu College, Buttala" width="2048" height="1536" loading="lazy">
                </div>
                <div class="stat-badge">
                    <strong>{{ date('Y') - $cfg['founded'] }}</strong>
                    <span>years of the college</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ Quick actions --}}
<section class="section section--paper">
    <div class="wrap">
        <div class="section-head center">
            <p class="eyebrow">How you can take part</p>
            <h2>Four ways to stay connected</h2>
        </div>
        <div class="grid grid--4">
            @foreach ($cfg['quick_actions'] as $qa)
                <div class="qa-card reveal">
                    <div class="qa-card__icon">
                        @switch($qa['icon'])
                            @case('card')
                                <svg viewBox="0 0 24 24"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="M2.5 9.5h19M6 15h5"/></svg>
                                @break
                            @case('calendar')
                                <svg viewBox="0 0 24 24"><rect x="3.5" y="4.5" width="17" height="16" rx="2"/><path d="M3.5 9h17M8 2.5v4M16 2.5v4M7.5 13h3M7.5 16.5h9"/></svg>
                                @break
                            @case('news')
                                <svg viewBox="0 0 24 24"><path d="M4 5h13v14H5a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1z"/><path d="M17 8h3v9a2 2 0 0 1-2 2M7 9h7M7 12.5h7M7 16h4"/></svg>
                                @break
                            @default
                                <svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-9.3-8.5C1.2 8.8 2.6 5.5 6 5.5c2 0 3.2 1.1 4 2.3.8-1.2 2-2.3 4-2.3 3.4 0 4.8 3.3 3.3 6C19 15.6 12 20 12 20z"/></svg>
                        @endswitch
                    </div>
                    @if ($qa['url'] === '/join' && auth('member')->check())
                        <h3>Your Membership</h3>
                        <p>You're a registered member. Visit your dashboard any time.</p>
                        <a href="{{ route('member.dashboard') }}" class="textlink">Go to Dashboard</a>
                    @else
                        <h3>{{ $qa['title'] }}</h3>
                        <p>{{ $qa['text'] }}</p>
                        <a href="{{ url($qa['url']) }}" class="textlink">{{ $qa['cta'] }}</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================ Stats --}}
<section class="section--tight section--maroon">
    <div class="wrap">
        <div class="stats">
            @foreach ($cfg['stats'] as $stat)
                <div class="stats__item">
                    <div class="stats__value">{{ $stat['value'] }}</div>
                    <div class="stats__label">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================ President's message --}}
<section class="section section--cream">
    <div class="wrap wrap--narrow">
        <div class="section-head">
            <p class="eyebrow">From the Vice Chairman</p>
            <h2>A word of welcome</h2>
        </div>
        <div class="message reveal">
            <div class="message__portrait">
                <img src="{{ asset($cfg['president_message']['photo']) }}" alt="{{ $cfg['president_message']['name'] }}" width="400" height="500">
            </div>
            <div>
                <blockquote>{{ $cfg['president_message']['body'][0] }}</blockquote>
                @foreach (array_slice($cfg['president_message']['body'], 1) as $para)
                    <p>{{ $para }}</p>
                @endforeach
                <div class="message__sign">
                    <strong>{{ $cfg['president_message']['name'] }}</strong>
                    <span>{{ $cfg['president_message']['title'] }}@if (!empty($cfg['president_message']['batch'])) &bull; {{ $cfg['president_message']['batch'] }}@endif</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ News + Events --}}
<section class="section section--paper">
    <div class="wrap">
        <div class="split split--wide-text" style="align-items:start">
            <div>
                <div class="section-head" style="margin-bottom:1.75rem">
                    <p class="eyebrow">Latest news</p>
                    <h2>From around the Association</h2>
                </div>
                <div class="grid" style="gap:1.5rem">
                    @foreach ($news as $item)
                        <article class="card card--row reveal">
                            <a href="{{ route('news.show', $item['slug']) }}" class="card__media">
                                <img src="{{ asset($item['image']) }}" alt="">
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
                <p style="margin-top:1.75rem"><a href="{{ route('news') }}" class="btn btn--ghost">All news</a></p>
            </div>

            <div>
                <div class="section-head" style="margin-bottom:1.75rem">
                    <p class="eyebrow">Diary</p>
                    <h2>Coming up</h2>
                </div>
                <ul class="events">
                    @foreach ($events as $ev)
                        <li class="event reveal">
                            <div class="event__date">
                                <span class="d">{{ $ev['date']->format('d') }}</span>
                                <span class="m">{{ $ev['date']->format('M') }}</span>
                                <span class="y">{{ $ev['date']->format('Y') }}</span>
                            </div>
                            <div class="event__body">
                                <h3>{{ $ev['title'] }}</h3>
                                <div class="event__where">
                                    <span>{{ $ev['location'] }}</span><span>{{ $ev['time'] }}</span>
                                </div>
                                <p>{{ $ev['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p style="margin-top:1.5rem"><a href="{{ route('news') }}#events" class="btn btn--ghost">Full calendar</a></p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ Gallery --}}
<section class="section section--paper">
    <div class="wrap">
        <div class="section-head center">
            <p class="eyebrow">In pictures</p>
            <h2>Best moment of Dutugemunu</h2>
        </div>
        <div class="gallery">
            @foreach ($cfg['gallery'] ?? [] as $g)
                <a href="{{ asset($g['path']) }}" class="{{ $g['size'] ?? '' }}" data-lightbox data-caption="{{ $g['caption'] }}">
                    <img src="{{ asset($g['path']) }}" alt="{{ $g['caption'] }}" loading="lazy">
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================ CTA --}}
<section class="section cta-band">
    <div class="wrap">
        @auth('member')
            <p class="eyebrow" style="color:var(--gold-soft)">Welcome back</p>
            <h2>Good to see you, {{ explode(' ', auth('member')->user()->full_name)[0] }}.</h2>
            <p>Your membership is active. Head to your dashboard to review your details or see what's coming up.</p>
            <div class="hero__actions">
                <a href="{{ route('member.dashboard') }}" class="btn btn--light">Go to My Dashboard</a>
                <a href="{{ route('contact') }}" class="btn btn--ondark">Talk to the Secretary</a>
            </div>
        @else
            <p class="eyebrow" style="color:var(--gold-soft)">Join us</p>
            <h2>Your school gave you a start. Return the favour.</h2>
            <p>Life membership connects you to old friends, the branch nearest you and every student your dues help along. It takes five minutes.</p>
            <div class="hero__actions">
                <a href="{{ route('join') }}" class="btn btn--light">Membership details</a>
                <a href="{{ route('contact') }}" class="btn btn--ondark">Talk to the Secretary</a>
            </div>
        @endauth
    </div>
</section>

@endsection
