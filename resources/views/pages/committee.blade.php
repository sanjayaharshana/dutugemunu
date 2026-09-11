@extends('layouts.app')

@section('title', 'The Committee')
@section('meta_description', 'The elected office bearers and committee of the Dutugemunu College Old Boys\' Association for 2026/27, its sub-committees, and how to become a member.')

@php($cfg = config('association'))
@php($com = $cfg['committee'])

@section('content')

@include('partials.page-hero', [
    'title'    => 'The Committee',
    'crumb'    => 'The Committee',
    'subtitle' => 'The office bearers and executive committee members who run the Association on behalf of the membership.',
])

{{-- Office bearers --}}
<section class="section section--cream">
    <div class="wrap">
        <div class="section-head">
            <p class="eyebrow">The committee board</p>
            <h2>Office Bearers</h2>
        </div>
        <div class="people">
            @foreach ($com['office_bearers'] as $person)
                <div class="person reveal">
                    <div class="person__photo">
                        <img src="{{ asset($person['photo']) }}" alt="{{ $person['name'] }}" width="400" height="400" loading="lazy">
                    </div>
                    <div class="person__body">
                        <span class="person__role">{{ $person['role'] }}</span>
                        <div class="person__name">{{ $person['name'] }}</div>
                        @if (!empty($person['batch']))
                            <div class="person__batch">Class of {{ $person['batch'] }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Committee members --}}
<section class="section section--paper">
    <div class="wrap">
        <div class="section-head">
            <p class="eyebrow">Also serving</p>
            <h2>Executive Committee Members</h2>
            <p>The board is completed by {{ count($com['members']) }} executive committee members who carry the Association's work forward through the year.</p>
        </div>
        <div class="people">
            @foreach ($com['members'] as $member)
                <div class="person reveal">
                    <div class="person__photo">
                        <img src="{{ asset($member['photo']) }}" alt="{{ $member['name'] }}" width="400" height="400" loading="lazy">
                    </div>
                    <div class="person__body">
                        <span class="person__role">Committee Member</span>
                        <div class="person__name">{{ $member['name'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Sub-committees --}}
<section class="section section--sand" id="sub-committees">
    <div class="wrap">
        <div class="section-head">
            <p class="eyebrow">How the work gets done</p>
            <h2>Sub-Committees</h2>
            <p>The real work of the Association happens in its sub-committees. Every member is welcome to join one &mdash; it is the quickest way to make a difference.</p>
        </div>
        <div class="mini-grid reveal">
            @foreach ($com['sub_committees'] as $sc)
                <div class="mini">
                    <h4>{{ $sc['name'] }}</h4>
                    <p>{{ $sc['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Membership --}}
<section class="section section--maroon" id="membership">
    <div class="wrap">
        <div class="split">
            <div>
                <p class="eyebrow">Membership</p>
                <h2>Become a member</h2>
                <p>Any past student of Dutugemunu College is eligible for membership. Life membership is a single payment that never expires &mdash; and it opens every door the Association has.</p>
                <ul class="tick-list" style="--gold:#e7d4a8;color:rgba(255,255,255,.86);margin-top:1.5rem">
                    <li>A vote at the Annual General Meeting</li>
                    <li>The newsletter and members' bulletins</li>
                    <li>An introduction to the branch nearest you</li>
                    <li>A place at the Annual Dinner and reunions</li>
                    <li>Access to the career mentoring network</li>
                </ul>
            </div>
            <div class="form" style="color:var(--body)">
                <h3 style="margin-bottom:.4rem">Request a membership pack</h3>
                <p style="font-size:.95rem;color:var(--body)">Fill this in and the Secretary will send you the current rate and the application form.</p>
                <form data-demo data-email="{{ $cfg['contact']['email'] }}">
                    <div class="form__row">
                        <div class="field">
                            <label for="m-name">Full name</label>
                            <input type="text" id="m-name" name="name" required>
                        </div>
                        <div class="field">
                            <label for="m-year">Year you left</label>
                            <input type="text" id="m-year" name="year" placeholder="e.g. 1998" required>
                        </div>
                    </div>
                    <div class="form__row">
                        <div class="field">
                            <label for="m-email">Email</label>
                            <input type="email" id="m-email" name="email" required>
                        </div>
                        <div class="field">
                            <label for="m-phone">Phone</label>
                            <input type="tel" id="m-phone" name="phone">
                        </div>
                    </div>
                    <div class="field">
                        <label for="m-city">City / country you live in now</label>
                        <input type="text" id="m-city" name="city">
                    </div>
                    <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center">Send request</button>
                    <p class="form__note">This form is a demonstration and does not yet submit. Please email
                        <a href="mailto:{{ $cfg['contact']['email'] }}">{{ $cfg['contact']['email'] }}</a> in the meantime.</p>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
