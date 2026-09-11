@extends('layouts.app')

@section('title', 'Member Login')
@section('meta_description', 'Log in to your Dutugemunu College Old Students\' Association member account.')

@section('content')

@include('partials.page-hero', [
    'title'    => 'Member Login',
    'crumb'    => 'Member Login',
    'subtitle' => 'Log in with the NIC number and password you registered with.',
])

<section class="section section--cream">
    <div class="wrap" style="max-width:480px">
        <form class="form" method="POST" action="{{ route('member.login.attempt') }}">
            @csrf

            @if ($errors->any())
                <div style="background:var(--maroon-soft);color:var(--maroon);border-radius:var(--radius);padding:.9rem 1.1rem;margin-bottom:1.2rem;font-weight:600">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="field">
                <label for="nic">National Identity Card Number</label>
                <input type="text" id="nic" name="nic" value="{{ old('nic') }}" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <label class="field" style="display:flex;align-items:center;gap:.5rem;font-weight:400">
                <input type="checkbox" name="remember" value="1" style="width:auto"> Keep me signed in
            </label>

            <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center">Log In</button>
            <p class="form__note" style="text-align:center;margin-top:1rem">Not a member yet? <a href="{{ route('join') }}">Become a member</a>.</p>
        </form>
    </div>
</section>

@endsection
