<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in · {{ config('association.short_name', 'DCOSA') }} Admin</title>
    <link rel="icon" href="{{ asset('images/favicon-96.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login-wrap">
    <form class="login-card" method="POST" action="{{ route('admin.login.attempt') }}">
        @csrf
        <div class="login-card__brand">
            <img src="{{ asset('images/logo-256.png') }}" alt="">
            <div>
                <strong>Dutugemunu College<br>Old Students' Association</strong>
                <span>Admin panel</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="flash flash--err">{{ $errors->first() }}</div>
        @endif

        <div class="field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">
        </div>
        <label class="field" style="display:flex;align-items:center;gap:.5rem;font-weight:400">
            <input type="checkbox" name="remember" value="1" style="width:auto"> Keep me signed in
        </label>

        <button type="submit" class="btn btn--primary" style="width:100%;justify-content:center">Sign in</button>
    </form>
</div>
</body>
</html>
