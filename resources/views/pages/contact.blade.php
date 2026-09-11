@extends('layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with the Dutugemunu College Old Students\' Association, Buttala — the Association office, the Secretary, and answers to common questions.')

@php($c = config('association.contact'))

@section('content')

@include('partials.page-hero', [
    'title'    => 'Contact Us',
    'crumb'    => 'Contact',
    'subtitle' => 'Questions about membership, events, a branch or a project? Start here.',
])

<section class="section section--cream">
    <div class="wrap">
        <div class="split" style="align-items:start">
            {{-- Form --}}
            <div class="reveal">
                <p class="eyebrow">Send a message</p>
                <h2>Write to the Secretary</h2>
                <p>Use the form below and we will reply by email, usually within a few days.</p>
                <form class="form" data-demo data-email="{{ $c['email'] }}">
                    <div class="form__row">
                        <div class="field">
                            <label for="c-name">Your name</label>
                            <input type="text" id="c-name" name="name" required>
                        </div>
                        <div class="field">
                            <label for="c-year">Year you left <span style="font-weight:400;color:var(--muted)">(if an old student)</span></label>
                            <input type="text" id="c-year" name="year" placeholder="e.g. 1998">
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="field">
                            <label for="c-email">Email</label>
                            <input type="email" id="c-email" name="email" required>
                        </div>
                        <div class="field">
                            <label for="c-topic">Topic</label>
                            <select id="c-topic" name="topic">
                                <option>Membership</option>
                                <option>Events &amp; reunions</option>
                                <option>Branches</option>
                                <option>Projects &amp; donations</option>
                                <option>Newsletter &amp; media</option>
                                <option>Something else</option>
                            </select>
                        </div>
                    </div>
                    <div class="field">
                        <label for="c-message">Message</label>
                        <textarea id="c-message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center">Send message</button>
                    <p class="form__note">This form is a demonstration and does not yet submit. Please email
                        <a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a> directly for now.</p>
                </form>
            </div>

            {{-- Details --}}
            <div class="reveal">
                <p class="eyebrow">The Association office</p>
                <h2>Where to find us</h2>
                <ul class="info-list">
                    <li>
                        <svg viewBox="0 0 24 24"><path d="M12 21s-7-5.2-7-11a7 7 0 0 1 14 0c0 5.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        <span><strong>Address</strong>{{ $c['address'] }}</span>
                    </li>
                    {{-- Phone number hidden for now (ask before re-enabling) --}}
                    <li>
                        <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M4 7l8 6 8-6"/></svg>
                        <span><strong>Email</strong><a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a></span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                        <span><strong>Office hours</strong>{{ $c['hours'] }}</span>
                    </li>
                </ul>

                <div class="map-frame" style="margin-top:1.5rem">
                    <img src="{{ asset('images/map.svg') }}" alt="Map showing Dutugemunu College, Buttala">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="section section--paper">
    <div class="wrap wrap--narrow">
        <div class="section-head">
            <p class="eyebrow">Before you write</p>
            <h2>Frequently asked</h2>
        </div>
        <div class="faq reveal">
            @foreach (config('association.faqs') as $faq)
                <details @if ($loop->first) open @endif>
                    <summary>{{ $faq['q'] }}</summary>
                    <p>{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

@endsection
