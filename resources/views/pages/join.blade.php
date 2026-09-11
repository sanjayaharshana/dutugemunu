@extends('layouts.app')

@section('title', 'Become a Member')
@section('meta_description', 'Join the Dutugemunu College Old Students\' Association — complete the membership form to create your account.')

@section('content')

@include('partials.page-hero', [
    'title'    => 'Become a Member',
    'crumb'    => 'Become a Member',
    'subtitle' => 'Complete the form below to register. It takes about five minutes, and ends with you choosing a password for your member account.',
])

<section class="section section--cream">
    <div class="wrap wrap--narrow">

        @if ($errors->any())
            <div class="form__note" style="background:var(--maroon-soft);color:var(--maroon);border-radius:var(--radius);padding:1rem 1.2rem;margin-bottom:1.5rem;font-weight:600">
                Please check the details below:
                <ul style="margin:.5rem 0 0;font-weight:400">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form wizard-form" method="POST" action="{{ route('join.store') }}" novalidate>
            @csrf

            <div class="wizard-progress" aria-hidden="true">
                <span class="wizard-progress__step" data-goto="1"><em>1</em><b>Personal</b></span>
                <span class="wizard-progress__step" data-goto="2"><em>2</em><b>Work &amp; School</b></span>
                <span class="wizard-progress__step" data-goto="3"><em>3</em><b>Password</b></span>
            </div>

            {{-- Step 1 — Personal details --}}
            <fieldset class="wizard-step" data-step="1">
                <legend>Personal details</legend>

                <div class="field field--full">
                    <label for="full_name">සම්පූර්ණ නම (Full Name)</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $member->full_name) }}" required>
                </div>

                <div class="field field--full">
                    <label for="permanent_address">ස්ථිර ලිපිනය (Permanent Address)</label>
                    <textarea id="permanent_address" name="permanent_address" required>{{ old('permanent_address', $member->permanent_address) }}</textarea>
                </div>

                <div class="form__row">
                    <div class="field">
                        <label for="phone">දුරකථන අංකය (Phone Number)</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required>
                    </div>
                    <div class="field">
                        <label for="nic">ජාතික හැඳුනුම්පත් අංකය (National Identity Card Number)</label>
                        <input type="text" id="nic" name="nic" value="{{ old('nic') }}" placeholder="e.g. 912345678V or 199912345678" required>
                        <p class="form__note">This will also be your username to log in.</p>
                    </div>
                </div>

                <div class="wizard-nav">
                    <span></span>
                    <button type="button" class="btn btn--primary wizard-next">Next: Work &amp; School</button>
                </div>
            </fieldset>

            {{-- Step 2 — Work & school --}}
            <fieldset class="wizard-step" data-step="2">
                <legend>Work &amp; school details</legend>

                <div class="field field--full">
                    <label for="workplace_address_phone">රැකියා ස්ථානයෙහි ලිපිනය හා දුරකථන අංකය (Workplace Address and Phone Number) <span class="hint" style="font-weight:400;color:var(--muted)">(if applicable)</span></label>
                    <textarea id="workplace_address_phone" name="workplace_address_phone">{{ old('workplace_address_phone', $member->workplace_address_phone) }}</textarea>
                </div>

                <div class="field field--full">
                    <label for="occupation">වර්ථමාන රැකියාව (Current Occupation)</label>
                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation', $member->occupation) }}">
                </div>

                <div class="form__row">
                    <div class="field">
                        <label for="admission_number">පාසලට ඇතුලත් වීමේ අංකය (School Admission Number)</label>
                        <input type="text" id="admission_number" name="admission_number" value="{{ old('admission_number', $member->admission_number) }}" required>
                    </div>
                    <div class="field">
                        <label for="year_left">පාසලෙන් පිටව ගිය වර්ෂය (Year Left the School)</label>
                        <input type="text" inputmode="numeric" pattern="\d{4}" maxlength="4" id="year_left" name="year_left" value="{{ old('year_left', $member->year_left) }}" placeholder="e.g. 2005" required>
                    </div>
                </div>

                <div class="wizard-nav">
                    <button type="button" class="btn btn--ghost wizard-back">Back</button>
                    <button type="button" class="btn btn--primary wizard-next">Next: Password</button>
                </div>
            </fieldset>

            {{-- Step 3 — Password --}}
            <fieldset class="wizard-step" data-step="3">
                <legend>Create your password</legend>
                <p style="margin-top:-.4rem">One last thing — choose a password. You'll log in with your NIC number and this password.</p>

                <div class="form__row">
                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" minlength="8" required>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>
                    </div>
                </div>

                <div class="wizard-nav">
                    <button type="button" class="btn btn--ghost wizard-back">Back</button>
                    <button type="submit" class="btn btn--primary">Create My Account</button>
                </div>
            </fieldset>

            <p class="form__note" style="margin-top:1.5rem">Already a member? <a href="{{ route('member.login') }}">Log in here</a>.</p>
        </form>
    </div>
</section>

@endsection
