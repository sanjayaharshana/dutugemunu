@extends('layouts.app')

@section('title', 'Edit My Details')

@section('content')

@include('partials.page-hero', [
    'title'    => 'Edit My Details',
    'crumb'    => 'Edit My Details',
])

<section class="section section--cream">
    <div class="wrap wrap--narrow">

        @if ($errors->any())
            <div style="background:var(--maroon-soft);color:var(--maroon);border-radius:var(--radius);padding:.9rem 1.1rem;margin-bottom:1.5rem;font-weight:600">
                <ul style="margin:0;font-weight:400">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="form" method="POST" action="{{ route('member.profile.update') }}">
            @csrf
            @method('PUT')

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
                    <label for="occupation">වර්ථමාන රැකියාව (Current Occupation)</label>
                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation', $member->occupation) }}">
                </div>
            </div>

            <div class="field field--full">
                <label for="workplace_address_phone">රැකියා ස්ථානයෙහි ලිපිනය හා දුරකථන අංකය (Workplace Address and Phone Number)</label>
                <textarea id="workplace_address_phone" name="workplace_address_phone">{{ old('workplace_address_phone', $member->workplace_address_phone) }}</textarea>
            </div>

            <p class="form__note" style="margin-bottom:1rem">NIC number, school admission number and year left cannot be changed here — contact the Secretary if any of those need correcting.</p>

            <div class="form__row">
                <div class="field">
                    <label for="password">New Password <span class="hint" style="font-weight:400;color:var(--muted)">(leave blank to keep current)</span></label>
                    <input type="password" id="password" name="password" minlength="8">
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" minlength="8">
                </div>
            </div>

            <div class="form-actions" style="display:flex;gap:.8rem;margin-top:.5rem">
                <button type="submit" class="btn btn--primary">Save Changes</button>
                <a href="{{ route('member.dashboard') }}" class="btn btn--ghost">Cancel</a>
            </div>
        </form>
    </div>
</section>

@endsection
