@extends('layouts.app')

@section('title', 'About the Association')
@section('meta_description', 'The history, mission and objectives of the Dutugemunu College Old Boys\' Association, Buttala, its past presidents and its chapters at home and abroad.')

@php($cfg = config('association'))

@section('content')

@include('partials.page-hero', [
    'title'    => 'About the Association',
    'subtitle' => 'Who we are, where we came from, and what we set out to do for Dutugemunu College and its students.',
])

{{-- Intro split --}}
<section class="section section--cream">
    <div class="wrap">
        <div class="split">
            <div class="reveal">
                <p class="eyebrow">Our purpose</p>
                <h2>An alumni body with a job to do</h2>
                <p class="lead">The Dutugemunu College Old Boys' Association exists to keep past pupils connected to one another &mdash; and to keep all of us useful to the school in Buttala.</p>
                <p>We are a voluntary, non-political and non-sectarian body, run by an elected committee that serves without payment. Our accounts are independently audited and presented to members every year. Every rupee raised is spent on the college and its students.</p>
                <ul class="tick-list" style="margin-top:1.5rem">
                    @foreach ($cfg['objectives'] as $obj)
                        <li>{{ $obj }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="reveal media-offset">
                <div class="figure-frame figure-frame--offset">
                    <img src="{{ asset('images/about-2.svg') }}" alt="Founders of the Association" width="560" height="640">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mission / Vision / Values --}}
<section class="section section--paper">
    <div class="wrap">
        <div class="grid grid--3">
            <div class="value reveal">
                <span class="value__num">01</span>
                <h3>Mission</h3>
                <p>To bind the old boys of Dutugemunu College in fellowship, and to marshal their goodwill in service of the school's students and staff.</p>
            </div>
            <div class="value reveal">
                <span class="value__num">02</span>
                <h3>Vision</h3>
                <p>A Dutugemunu College where no student's potential is limited by their circumstances, backed by an old boys' community that shows up &mdash; year after year.</p>
            </div>
            <div class="value reveal">
                <span class="value__num">03</span>
                <h3>Values</h3>
                <p>Loyalty to the school. Fellowship without distinction of background. Service that is practical, transparent and lasting.</p>
            </div>
        </div>
    </div>
</section>

{{-- History timeline --}}
<section class="section section--sand" id="history">
    <div class="wrap wrap--narrow">
        <div class="section-head">
            <p class="eyebrow">Our history</p>
            <h2>From a thatched hut in 1919 to a family across the country</h2>
        </div>
        <ul class="timeline reveal">
            @foreach ($cfg['history'] as $h)
                <li>
                    <span class="timeline__year">{{ $h['year'] }}</span>
                    <p style="margin:0">{{ $h['text'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>

{{-- The crest --}}
<section class="section section--cream">
    <div class="wrap">
        <div class="split">
            <div class="reveal center" style="display:flex;justify-content:center">
                <img src="{{ asset('images/dlogo.png') }}" alt="The Dutugemunu College Old Boys' Association crest" style="width:260px">
            </div>
            <div class="reveal">
                <p class="eyebrow">The crest</p>
                <h2>The emblem we carry</h2>
                <p>At the heart of the shield is the <strong>Dhamma wheel</strong> above the <strong>lamp of learning</strong> resting on an open book &mdash; the pursuit of wisdom that the school exists to serve. The <strong>maroon and gold</strong> are the colours of Dutugemunu College.</p>
                <p>The banner reads <em lang="si">{{ $cfg['motto_si'] }}</em> &mdash; &ldquo;{{ $cfg['motto'] }}&rdquo; &mdash; while the ribbon below names the <strong>Old Boys' Association</strong> and the year it was founded, <strong>{{ $cfg['oba_founded'] }}</strong>.</p>
            </div>
        </div>
    </div>
</section>

{{-- Past presidents --}}
<section class="section section--paper">
    <div class="wrap wrap--narrow">
        <div class="section-head">
            <p class="eyebrow">Roll of honour</p>
            <h2>Past Presidents</h2>
        </div>
        <table class="roll reveal">
            <thead>
                <tr><th>President</th><th>Term of office</th></tr>
            </thead>
            <tbody>
                @foreach ($cfg['past_presidents'] as $p)
                    <tr><td>{{ $p['name'] }}</td><td>{{ $p['years'] }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

{{-- Branches --}}
<section class="section section--maroon" id="branches">
    <div class="wrap">
        <div class="split">
            <div>
                <p class="eyebrow">At home and abroad</p>
                <h2>Chapters wherever old boys gather</h2>
                <p>Wherever old boys have settled in numbers, a chapter has grown up around them &mdash; organising reunions, welcoming new arrivals and channelling support back to Buttala.</p>
                <p>Alongside the main body at the college, active groups meet in Colombo and Monaragala, with overseas chapters in the United Kingdom, Australia and the Middle East.</p>
                <a href="{{ route('contact') }}" class="btn btn--ondark" style="margin-top:1rem">Find your chapter</a>
            </div>
            <div class="stack">
                @foreach ($cfg['stats'] as $stat)
                    <div style="display:flex;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.15);padding-bottom:.75rem">
                        <span style="font-family:var(--font-display);font-size:1.6rem;color:#fff">{{ $stat['value'] }}</span>
                        <span style="align-self:end;letter-spacing:.08em;text-transform:uppercase;font-size:.8rem;color:var(--gold-soft)">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section cta-band">
    <div class="wrap">
        <h2>Ready to reconnect?</h2>
        <p>Whether you left last year or forty years ago, there is a place for you in the Association.</p>
        <div class="hero__actions">
            <a href="{{ route('committee') }}#membership" class="btn btn--light">Become a Member</a>
            <a href="{{ route('news') }}" class="btn btn--ondark">See what's happening</a>
        </div>
    </div>
</section>

@endsection
