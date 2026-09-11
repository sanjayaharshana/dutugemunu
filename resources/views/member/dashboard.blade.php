@extends('layouts.app')

@section('title', 'Member Panel')

@section('content')

@include('partials.page-hero', [
    'title'    => 'Welcome, ' . explode(' ', $member->full_name)[0],
    'crumb'    => 'Member Panel',
    'subtitle' => 'Your Dutugemunu College Old Students\' Association membership panel.',
])

<section class="section section--cream">
    <div class="wrap">

        @if (session('status'))
            <div style="background:var(--maroon-soft);color:var(--maroon);border-radius:var(--radius);padding:.9rem 1.1rem;margin-bottom:1.6rem;font-weight:600">
                {{ session('status') }}
            </div>
        @endif

        {{-- Profile summary strip — always visible, not part of the tabs --}}
        <div class="form" style="margin-bottom:2rem;display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap">
            <div>
                <h3 style="margin-bottom:.2rem">{{ $member->full_name }}</h3>
                <p style="margin:0;color:var(--muted);font-size:.92rem">
                    NIC {{ $member->nic }} &nbsp;&middot;&nbsp; {{ $member->phone }}
                    &nbsp;&middot;&nbsp; Member since {{ $member->created_at->format('j F Y') }}
                </p>
            </div>
            <div style="display:flex;gap:.6rem;flex:none">
                <a href="{{ route('member.profile.edit') }}" class="btn btn--ghost btn--sm" style="font-size:.82rem;padding:.55rem 1rem">Edit My Details</a>
                <form method="POST" action="{{ route('member.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn--ghost btn--sm" style="font-size:.82rem;padding:.55rem 1rem">Log Out</button>
                </form>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="tabs">
            <div class="tab-nav" role="tablist">
                <button type="button" class="tab-nav__btn" data-tab="funds">
                    <svg viewBox="0 0 24 24"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="M2.5 9.5h19M6 15h5"/></svg>
                    Current Funds
                </button>
                <button type="button" class="tab-nav__btn" data-tab="events">
                    <svg viewBox="0 0 24 24"><rect x="3.5" y="4.5" width="17" height="16" rx="2"/><path d="M3.5 9h17M8 2.5v4M16 2.5v4M7.5 13h3M7.5 16.5h9"/></svg>
                    Upcoming Events
                </button>
                <button type="button" class="tab-nav__btn" data-tab="news">
                    <svg viewBox="0 0 24 24"><path d="M4 5h13v14H5a2 2 0 0 1-2-2V6a1 1 0 0 1 1-1z"/><path d="M17 8h3v9a2 2 0 0 1-2 2M7 9h7M7 12.5h7M7 16h4"/></svg>
                    News and Updates
                </button>
                <button type="button" class="tab-nav__btn" data-tab="donations">
                    <svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-9.3-8.5C1.2 8.8 2.6 5.5 6 5.5c2 0 3.2 1.1 4 2.3.8-1.2 2-2.3 4-2.3 3.4 0 4.8 3.3 3.3 6C19 15.6 12 20 12 20z"/></svg>
                    Donations
                </button>
            </div>

            {{-- Current Funds --}}
            <div class="tab-panel" data-tab="funds">
                <p class="tab-panel__heading">Current Funds</p>

                <div class="fund-total">
                    <div>
                        <strong>{{ $funds['total_formatted'] ?? '—' }}</strong>
                    </div>
                    @if (!empty($funds['as_of']))
                        <span>As of {{ $funds['as_of'] }}</span>
                    @endif
                </div>

                @if (!empty($funds['breakdown']) && $funds['breakdown']->isNotEmpty())
                    <ul class="fund-list">
                        @foreach ($funds['breakdown'] as $row)
                            <li><span>{{ $row->category }}</span><b>{{ \App\Support\Money::format($row->net) }}</b></li>
                        @endforeach
                    </ul>
                @else
                    <p class="muted">Fund figures will appear here once published.</p>
                @endif

                <h3 class="fund-history__heading">Funds &amp; Members Growth</h3>
                <div class="growth-charts">
                    <div class="growth-chart">
                        <p class="growth-chart__title">Funds Growth</p>
                        @if (count($fundGrowth['labels']) < 2)
                            <p class="muted">Not enough data yet to plot a trend.</p>
                        @else
                            <div id="chart-funds-growth" class="growth-chart__canvas"
                                 data-labels='@json($fundGrowth['labels'])'
                                 data-values='@json($fundGrowth['values'])'
                                 data-format="money" data-color="#6a1b2a"></div>
                            <noscript><p class="muted">Enable JavaScript to see this chart.</p></noscript>
                        @endif
                    </div>
                    <div class="growth-chart">
                        <p class="growth-chart__title">Members Growth</p>
                        @if (count($memberGrowth['labels']) < 2)
                            <p class="muted">Not enough data yet to plot a trend.</p>
                        @else
                            <div id="chart-members-growth" class="growth-chart__canvas"
                                 data-labels='@json($memberGrowth['labels'])'
                                 data-values='@json($memberGrowth['values'])'
                                 data-format="count" data-color="#c19a4b"></div>
                            <noscript><p class="muted">Enable JavaScript to see this chart.</p></noscript>
                        @endif
                    </div>
                </div>

                @push('head')
                    <script src="{{ asset('vendor/echarts/echarts.min.js') }}" defer></script>
                @endpush

                <h3 class="fund-history__heading">Recent transactions</h3>
                @if ($transactions->isEmpty())
                    <p class="muted">No transactions recorded yet.</p>
                @else
                    <div class="fund-history">
                        <table class="fund-history__table">
                            <thead><tr><th>Date</th><th>Fund</th><th>Description</th><th>Amount</th></tr></thead>
                            <tbody>
                            @foreach ($transactions as $t)
                                <tr>
                                    <td>{{ $t->date->format('j M Y') }}</td>
                                    <td>{{ $t->category }}</td>
                                    <td>{{ $t->title }}</td>
                                    <td class="{{ $t->isAddition() ? 'is-in' : 'is-out' }}">
                                        {{ $t->isAddition() ? '+' : '−' }} {{ $t->amountFormatted() }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Upcoming Events --}}
            <div class="tab-panel" data-tab="events">
                <p class="tab-panel__heading">Upcoming Events</p>

                @if ($events->isEmpty())
                    <p class="muted">No upcoming events right now.</p>
                @else
                    <ul class="events">
                        @foreach ($events as $ev)
                            <li class="event">
                                <div class="event__date">
                                    <span class="d">{{ $ev['date']->format('d') }}</span>
                                    <span class="m">{{ $ev['date']->format('M') }}</span>
                                    <span class="y">{{ $ev['date']->format('Y') }}</span>
                                </div>
                                <div class="event__body">
                                    <h3>{{ $ev['title'] }}</h3>
                                    <div class="event__where"><span>{{ $ev['location'] }}</span><span>{{ $ev['time'] }}</span></div>
                                    <p>{{ $ev['text'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- News and Updates --}}
            <div class="tab-panel" data-tab="news">
                <p class="tab-panel__heading">News and Updates</p>

                @if ($news->isEmpty())
                    <p class="muted">No news yet.</p>
                @else
                    <ul class="events">
                        @foreach ($news as $item)
                            <li class="event">
                                <div class="event__date" style="background:var(--muted)">
                                    <span class="d">{{ $item['date']->format('d') }}</span>
                                    <span class="m">{{ $item['date']->format('M') }}</span>
                                    <span class="y">{{ $item['date']->format('Y') }}</span>
                                </div>
                                <div class="event__body">
                                    <span class="tag" style="margin-bottom:.4rem;display:inline-block">{{ $item['tag'] }}</span>
                                    <h3><a href="{{ route('news.show', $item['slug']) }}">{{ $item['title'] }}</a></h3>
                                    <p>{{ $item['excerpt'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <p style="margin-top:1.5rem"><a href="{{ route('news') }}" class="btn btn--ghost btn--sm" style="font-size:.82rem;padding:.55rem 1rem">All news &amp; events</a></p>
                @endif
            </div>

            {{-- Donations --}}
            <div class="tab-panel" data-tab="donations">
                <p class="tab-panel__heading">Donations</p>

                @if (!empty($donations['intro']))
                    <p>{{ $donations['intro'] }}</p>
                @endif

                <div class="bank-card">
                    <dl>
                        <dt>Bank</dt><dd>{{ $donations['bank_name'] ?? '—' }}</dd>
                        <dt>Account Name</dt><dd>{{ $donations['account_name'] ?? '—' }}</dd>
                        <dt>Account Number</dt><dd>{{ $donations['account_number'] ?? '—' }}</dd>
                        <dt>Branch</dt><dd>{{ $donations['branch'] ?? '—' }}</dd>
                    </dl>
                </div>

                <p class="form__note" style="margin-top:1.2rem">Made a transfer, or have a question? <a href="{{ route('contact') }}">Contact the Secretary</a>.</p>
            </div>
        </div>
    </div>
</section>

@endsection
