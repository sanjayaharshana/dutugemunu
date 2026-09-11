@php($c = config('association.contact'))
@php($s = config('association.social'))
<div class="topbar">
    <div class="wrap">
        <div class="topbar__meta">
            {{-- Phone number hidden for now (ask before re-enabling) --}}
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm9 7L4 7v1l8 5 8-5V7l-8 5z"/></svg>
                <a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a>
            </span>
        </div>
        <div class="topbar__social">
            @auth('member')
                <a href="{{ route('member.dashboard') }}" class="topbar__member">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-9 2.2-9 5v3h18v-3c0-2.8-4.6-5-9-5z"/></svg>
                    My Account
                </a>
            @else
                <a href="{{ route('member.login') }}" class="topbar__member">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-9 2.2-9 5v3h18v-3c0-2.8-4.6-5-9-5z"/></svg>
                    Member Login
                </a>
            @endauth
            <a href="{{ $s['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook">
                <svg viewBox="0 0 24 24"><path d="M13 22v-9h3l.5-3.5H13V7.3c0-1 .3-1.8 1.8-1.8H17V2.3C16.6 2.2 15.4 2 14 2c-2.9 0-4.9 1.8-4.9 5v3.5H6V14h3.1v9H13z"/></svg>
            </a>
            <a href="{{ $s['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram">
                <svg viewBox="0 0 24 24"><path d="M12 2c2.7 0 3 0 4.1.1 1.1 0 1.8.2 2.4.5.7.2 1.2.6 1.7 1.1s.9 1 1.1 1.7c.3.6.5 1.3.5 2.4C22 9 22 9.3 22 12s0 3-.1 4.1c0 1.1-.2 1.8-.5 2.4a4.7 4.7 0 0 1-1.1 1.7c-.5.5-1 .9-1.7 1.1-.6.3-1.3.5-2.4.5C15 22 14.7 22 12 22s-3 0-4.1-.1c-1.1 0-1.8-.2-2.4-.5a4.7 4.7 0 0 1-1.7-1.1 4.7 4.7 0 0 1-1.1-1.7c-.3-.6-.5-1.3-.5-2.4C2 15 2 14.7 2 12s0-3 .1-4.1c0-1.1.2-1.8.5-2.4A4.7 4.7 0 0 1 3.7 3.7 4.7 4.7 0 0 1 5.4 2.6c.6-.3 1.3-.5 2.4-.5C9 2 9.3 2 12 2zm0 1.8c-2.7 0-3 0-4 .1-.9 0-1.4.2-1.7.3-.4.2-.7.4-1 .7-.3.3-.5.6-.7 1-.1.3-.3.8-.3 1.7 0 1-.1 1.3-.1 4s0 3 .1 4c0 .9.2 1.4.3 1.7.2.4.4.7.7 1 .3.3.6.5 1 .7.3.1.8.3 1.7.3 1 0 1.3.1 4 .1s3 0 4-.1c.9 0 1.4-.2 1.7-.3.4-.2.7-.4 1-.7.3-.3.5-.6.7-1 .1-.3.3-.8.3-1.7 0-1 .1-1.3.1-4s0-3-.1-4c0-.9-.2-1.4-.3-1.7a2.8 2.8 0 0 0-.7-1 2.8 2.8 0 0 0-1-.7c-.3-.1-.8-.3-1.7-.3-1 0-1.3-.1-4-.1zm0 3a5.2 5.2 0 1 1 0 10.4 5.2 5.2 0 0 1 0-10.4zm0 1.8a3.4 3.4 0 1 0 0 6.8 3.4 3.4 0 0 0 0-6.8zm5.4-.9a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0z"/></svg>
            </a>
            <a href="{{ $s['youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube">
                <svg viewBox="0 0 24 24"><path d="M23 12s0-3.2-.4-4.7c-.2-.9-.9-1.5-1.8-1.8C19.3 5 12 5 12 5s-7.3 0-8.8.5c-.9.3-1.6.9-1.8 1.8C1 8.8 1 12 1 12s0 3.2.4 4.7c.2.9.9 1.5 1.8 1.8C4.7 19 12 19 12 19s7.3 0 8.8-.5c.9-.3 1.6-.9 1.8-1.8.4-1.5.4-4.7.4-4.7zm-13 3V9l5.2 3L10 15z"/></svg>
            </a>
            <a href="{{ $s['linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M6.9 8v12H3V8h3.9zM5 2.2A2.3 2.3 0 1 1 5 6.8a2.3 2.3 0 0 1 0-4.6zM21 20h-3.9v-6c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.8 1.3-.1.2-.1.5-.1.8V20H9.5V8h3.8v1.6c.5-.8 1.4-1.9 3.4-1.9 2.5 0 4.3 1.6 4.3 5.1V20z"/></svg>
            </a>
        </div>
    </div>
</div>
