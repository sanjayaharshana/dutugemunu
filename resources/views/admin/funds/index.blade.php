@extends('admin.layout')
@section('title', 'Fund Transactions')
@section('heading', 'Fund Transactions')
@section('subheading', 'Every addition and deduction here updates the total balance and fund breakdown shown to members on their dashboard.')
@section('actions')
    <a href="{{ route('admin.funds.create') }}" class="btn btn--primary">+ Record transaction</a>
@endsection

@section('content')
    <div class="stat-grid mt">
        <div class="stat stat--sm" title="{{ \App\Support\Money::format($total) }}"><b>{{ \App\Support\Money::abbreviate($total) }}</b><span>Current balance</span></div>
        <div class="stat stat--sm" title="{{ \App\Support\Money::format($additions) }}"><b>{{ \App\Support\Money::abbreviate($additions) }}</b><span>Total additions</span></div>
        <div class="stat stat--sm" title="{{ \App\Support\Money::format($deductions) }}"><b>{{ \App\Support\Money::abbreviate($deductions) }}</b><span>Total deductions</span></div>
        <div class="stat"><b>{{ $transactions->count() }}</b><span>Transactions</span></div>
    </div>

    @if ($breakdown->isNotEmpty())
        <div class="panel">
            <h2>Balance by fund</h2>
            <div class="table-scroll">
                <table class="table">
                    <thead><tr><th>Fund</th><th>Balance</th></tr></thead>
                    <tbody>
                    @foreach ($breakdown as $row)
                        <tr>
                            <td>{{ $row->category }}</td>
                            <td><strong>{{ \App\Support\Money::format($row->net) }}</strong></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="panel">
        <h2>All transactions</h2>
        @if ($transactions->isEmpty())
            <p class="muted">No transactions recorded yet. Use “Record transaction” to add the first one.</p>
        @else
            <div class="table-scroll">
                <table class="table">
                    <thead><tr><th>Date</th><th>Fund</th><th>Description</th><th>Type</th><th>Amount</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($transactions as $t)
                        <tr>
                            <td class="muted">{{ $t->date->format('j M Y') }}</td>
                            <td>{{ $t->category }}</td>
                            <td><a href="{{ route('admin.funds.edit', $t) }}"><strong>{{ $t->title }}</strong></a></td>
                            <td>
                                @if ($t->isAddition())
                                    <span class="pill pill--ok">Addition</span>
                                @else
                                    <span class="pill pill--danger">Deduction</span>
                                @endif
                            </td>
                            <td class="{{ $t->isAddition() ? 'amt-ok' : 'amt-bad' }}">
                                {{ $t->isAddition() ? '+' : '−' }} {{ $t->amountFormatted() }}
                            </td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.funds.edit', $t) }}" class="btn btn--ghost btn--sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.funds.destroy', $t) }}" class="inline-form"
                                          onsubmit="return confirm('Delete this transaction? This changes the total shown to members.')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn--danger btn--sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
