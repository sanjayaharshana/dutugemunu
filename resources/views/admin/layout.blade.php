<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') · {{ config('association.short_name', 'DCOBA') }} Admin</title>
    <link rel="icon" href="{{ asset('images/favicon-96.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@php($nav = [
    ['admin.dashboard', 'Dashboard', ['admin.dashboard']],
    ['admin.committee.index', 'Committee', ['admin.committee.*']],
    ['admin.news.index', 'News', ['admin.news.*']],
    ['admin.events.index', 'Events', ['admin.events.*']],
    ['admin.media.index', 'Gallery & Hero', ['admin.media.*']],
    ['admin.settings.edit', 'Site Settings', ['admin.settings.*']],
])
<div class="admin">
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar__brand">
            <img src="{{ asset('images/logo-256.png') }}" alt="">
            <b>DCOBA<br>Admin</b>
        </a>
        @foreach ($nav as [$route, $label, $patterns])
            <a href="{{ route($route) }}" @class(['is-active' => request()->routeIs($patterns)])>{{ $label }}</a>
        @endforeach
        <div class="sidebar__foot stack-sm">
            <div class="muted" style="padding:.4rem .75rem">{{ auth()->user()?->name }}</div>
            <a href="{{ route('home') }}" target="_blank" rel="noopener">View website ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn--link" style="color:rgba(255,255,255,.85)">Sign out</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topline">
            <div>
                <h1>@yield('heading', 'Dashboard')</h1>
                @hasSection('subheading')<p>@yield('subheading')</p>@endif
            </div>
            <div>@yield('actions')</div>
        </div>

        @if (session('status'))
            <div class="flash flash--ok">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="flash flash--err">
                Please fix the following:
                <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
