<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') · {{ config('association.short_name', 'DCOSA') }} Admin</title>
    <link rel="icon" href="{{ asset('images/favicon-96.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@php($unreadMessages = \App\Models\ContactMessage::whereNull('read_at')->count())
@php($nav = [
    ['admin.dashboard', 'Dashboard', ['admin.dashboard'], 0],
    ['admin.committee.index', 'Committee', ['admin.committee.*'], 0],
    ['admin.members.index', 'Members', ['admin.members.*'], 0],
    ['admin.funds.index', 'Funds', ['admin.funds.*'], 0],
    ['admin.messages.index', 'Messages', ['admin.messages.*'], $unreadMessages],
    ['admin.news.index', 'News', ['admin.news.*'], 0],
    ['admin.events.index', 'Events', ['admin.events.*'], 0],
    ['admin.media.index', 'Gallery & Hero', ['admin.media.*'], 0],
    ['admin.settings.edit', 'Site Settings', ['admin.settings.*'], 0],
])
<div class="admin">
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar__brand">
            <img src="{{ asset('images/logo-256.png') }}" alt="">
            <b>DCOSA<br>Admin</b>
        </a>
        @foreach ($nav as [$route, $label, $patterns, $badge])
            <a href="{{ route($route) }}" @class(['is-active' => request()->routeIs($patterns)])>
                {{ $label }}
                @if ($badge > 0)<span class="sidebar__badge">{{ $badge }}</span>@endif
            </a>
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
