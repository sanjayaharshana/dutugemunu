@extends('layouts.app')

@section('title', 'The Committee')
@section('meta_description', 'The elected office bearers and committee of the Dutugemunu College Old Students\' Association for 2026/27, its sub-committees, and how to become a member.')

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
            <div class="form" style="color:var(--body);text-align:center">
                @auth('member')
                    <h3 style="margin-bottom:.4rem">You're already a member</h3>
                    <p style="font-size:.95rem;color:var(--body)">Head to your dashboard to review your membership details or update your contact information.</p>
                    <a href="{{ route('member.dashboard') }}" class="btn btn--primary" style="width:100%;justify-content:center;margin-top:.5rem">Go to My Dashboard</a>
                @else
                    <h3 style="margin-bottom:.4rem">Register in five minutes</h3>
                    <p style="font-size:.95rem;color:var(--body)">Our online membership form walks you through your details step by step and ends with you setting up your own login — so you can come back any time and see your membership details.</p>
                    <a href="{{ route('join') }}" class="btn btn--primary" style="width:100%;justify-content:center;margin-top:.5rem">Start the Membership Form</a>
                    <p class="form__note" style="margin-top:1rem">Already registered? <a href="{{ route('member.login') }}">Log in to your member panel</a>.</p>
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection
