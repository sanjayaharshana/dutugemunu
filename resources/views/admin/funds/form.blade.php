@extends('admin.layout')
@section('title', $transaction->exists ? 'Edit transaction' : 'Record transaction')
@section('heading', $transaction->exists ? 'Edit transaction' : 'Record transaction')

@section('content')
    <form class="panel" method="POST"
          action="{{ $transaction->exists ? route('admin.funds.update', $transaction) : route('admin.funds.store') }}">
        @csrf
        @if ($transaction->exists) @method('PUT') @endif

        <div class="form-grid">
            <div class="field">
                <label for="type">Type</label>
                <select name="type" id="type" required>
                    <option value="addition" @selected(old('type', $transaction->type) === 'addition')>Addition (money in)</option>
                    <option value="deduction" @selected(old('type', $transaction->type) === 'deduction')>Deduction (money out)</option>
                </select>
                @error('type')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="amount">Amount (Rs.)</label>
                <input type="number" step="0.01" min="0.01" name="amount" id="amount"
                       value="{{ old('amount', $transaction->amount) }}" required>
                @error('amount')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="date">Date</label>
                <input type="date" name="date" id="date"
                       value="{{ old('date', optional($transaction->date)->format('Y-m-d')) }}" required>
                @error('date')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="category">Fund <span class="hint">(pick one or type a new name)</span></label>
                <input type="text" name="category" id="category" list="fund-categories"
                       value="{{ old('category', $transaction->category ?? 'General Fund') }}" required>
                <datalist id="fund-categories">
                    @foreach (\App\Models\FundTransaction::CATEGORIES as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
                @error('category')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field field--full">
                <label for="title">Description <span class="hint">(shown to members, e.g. “Membership fees — August 2026”)</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $transaction->title) }}" required>
                @error('title')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field field--full">
                <label for="notes">Internal notes <span class="hint">(admin-only — not shown to members)</span></label>
                <textarea name="notes" id="notes" style="min-height:80px">{{ old('notes', $transaction->notes) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn--primary">Save</button>
            <a href="{{ route('admin.funds.index') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
@endsection
