@php($c = config('association.contact'))
@php($s = config('association.social'))
<footer class="site-footer">
    <div class="wrap">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/logo-256.png') }}" alt="">
                    <strong>Dutugemunu College<br>Old Students' Association</strong>
                </div>
                <p>Binding past pupils of Dutugemunu College, Buttala in fellowship and service to the school since {{ config('association.oba_founded') }}.</p>
                <div class="footer-social">
                    <a href="{{ $s['facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 22v-9h3l.5-3.5H13V7.3c0-1 .3-1.8 1.8-1.8H17V2.3C16.6 2.2 15.4 2 14 2c-2.9 0-4.9 1.8-4.9 5v3.5H6V14h3.1v9H13z"/></svg></a>
                    <a href="{{ $s['instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c2.7 0 3 0 4.1.1 1.1 0 1.8.2 2.4.5.7.3 1.3.7 1.8 1.2s.9 1.1 1.1 1.8c.3.6.5 1.3.5 2.4C22 9 22 9.3 22 12s0 3-.1 4.1c0 1.1-.2 1.8-.5 2.4a4.7 4.7 0 0 1-1.1 1.7c-.5.5-1 .9-1.7 1.1-.6.3-1.3.5-2.4.5-1.1.1-1.4.1-4.1.1s-3 0-4.1-.1c-1.1 0-1.8-.2-2.4-.5a4.7 4.7 0 0 1-1.7-1.1 4.7 4.7 0 0 1-1.1-1.7c-.3-.6-.5-1.3-.5-2.4C2 15 2 14.7 2 12s0-3 .1-4.1c0-1.1.2-1.8.5-2.4A4.7 4.7 0 0 1 3.7 3.8 4.7 4.7 0 0 1 5.4 2.7c.6-.3 1.3-.5 2.4-.5C9 2 9.3 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 1.8a3.2 3.2 0 1 1 0 6.4 3.2 3.2 0 0 1 0-6.4zm5.3-.6a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0z"/></svg></a>
                    <a href="{{ $s['youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.2-.4-4.7c-.2-.9-.9-1.5-1.8-1.8C19.3 5 12 5 12 5s-7.3 0-8.8.5c-.9.3-1.6.9-1.8 1.8C1 8.8 1 12 1 12s0 3.2.4 4.7c.2.9.9 1.5 1.8 1.8C4.7 19 12 19 12 19s7.3 0 8.8-.5c.9-.3 1.6-.9 1.8-1.8.4-1.5.4-4.7.4-4.7zm-13 3V9l5.2 3L10 15z"/></svg></a>
                    <a href="{{ $s['linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.9 8v12H3V8h3.9zM5 2.2A2.3 2.3 0 1 1 5 6.8a2.3 2.3 0 0 1 0-4.6zM21 20h-3.9v-6c0-1.5-.5-2.5-1.8-2.5-1 0-1.6.7-1.8 1.3-.1.2-.1.5-.1.8V20H9.5V8h3.8v1.6c.5-.8 1.4-1.9 3.4-1.9 2.5 0 4.3 1.6 4.3 5.1V20z"/></svg></a>
                </div>
            </div>

            <div>
                <h4>Explore</h4>
                <ul>
                    <li><a href="{{ route('about') }}">About the Association</a></li>
                    <li><a href="{{ route('about') }}#history">Our History</a></li>
                    <li><a href="{{ route('committee') }}">The Committee</a></li>
                    <li><a href="{{ route('news') }}">News &amp; Events</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('downloads') }}">Downloads</a></li>
                </ul>
            </div>

            <div>
                <h4>Get Involved</h4>
                <ul>
                    @auth('member')
                        <li><a href="{{ route('member.dashboard') }}">My Dashboard</a></li>
                    @else
                        <li><a href="{{ route('join') }}">Become a Member</a></li>
                    @endauth
                    <li><a href="{{ route('news') }}#events">Upcoming Events</a></li>
                    <li><a href="{{ route('committee') }}#sub-committees">Sub-Committees</a></li>
                    <li><a href="{{ route('contact') }}">Support a Project</a></li>
                    <li><a href="{{ route('about') }}#branches">Chapters &amp; Reunions</a></li>
                </ul>
            </div>

            <div>
                <h4>Association Office</h4>
                <p>{{ $c['address'] }}</p>
                <p>
                    {{-- Phone number hidden for now (ask before re-enabling) --}}
                    <a href="mailto:{{ $c['email'] }}">{{ $c['email'] }}</a>
                </p>
                <form class="footer-newsletter" data-demo data-email="{{ $c['email'] }}" aria-label="Newsletter sign-up">
                    <label class="sr-only" for="nl-email">Email address</label>
                    <input type="email" id="nl-email" placeholder="Email for the newsletter" required>
                    <button type="submit" class="btn btn--light" style="width:100%;justify-content:center">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="footer-note">
            <span>&copy; {{ config('association.oba_founded') }}&ndash;<span id="year">{{ date('Y') }}</span> {{ config('association.name') }}. All rights reserved.</span>
            <span>Built with care by the old students of Dutugemunu College, Buttala.</span>
        </div>
    </div>
</footer>
