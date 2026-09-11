@extends('admin.layout')
@section('title', 'Site Settings')
@section('heading', 'Site Settings')
@section('subheading', 'Association name, contact details, social links, the headline stats and the Chairman/Vice Chairman message.')

@php($g = fn ($k, $d = '') => old("general.$k", data_get($general, $k, $d)))
@php($c = fn ($k, $d = '') => old("contact.$k", data_get($contact, $k, $d)))
@php($s = fn ($k, $d = '') => old("social.$k", data_get($social, $k, $d)))
@php($m = fn ($k, $d = '') => old("message.$k", data_get($message, $k, $d)))
@php($dn = fn ($k, $d = '') => old("donations.$k", data_get($donations, $k, $d)))

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="panel">
            <h2>General</h2>
            <div class="form-grid">
                <div class="field field--full">
                    <label>Association name</label>
                    <input type="text" name="general[name]" value="{{ $g('name') }}" required>
                </div>
                <div class="field"><label>Short name</label><input type="text" name="general[short_name]" value="{{ $g('short_name') }}"></div>
                <div class="field"><label>College name</label><input type="text" name="general[college]" value="{{ $g('college') }}"></div>
                <div class="field"><label>Location</label><input type="text" name="general[location]" value="{{ $g('location') }}"></div>
                <div class="field"><label>Founded (year shown on site)</label><input type="text" name="general[founded]" value="{{ $g('founded') }}"></div>
                <div class="field"><label>Motto (English)</label><input type="text" name="general[motto]" value="{{ $g('motto') }}"></div>
                <div class="field"><label>Motto (Sinhala)</label><input type="text" name="general[motto_si]" value="{{ $g('motto_si') }}"></div>
                <div class="field"><label>Association founded</label><input type="text" name="general[oba_founded]" value="{{ $g('oba_founded') }}"></div>
            </div>
        </div>

        <div class="panel">
            <h2>Contact</h2>
            <div class="form-grid">
                <div class="field field--full"><label>Address</label><input type="text" name="contact[address]" value="{{ $c('address') }}"></div>
                <div class="field"><label>Phone</label><input type="text" name="contact[phone]" value="{{ $c('phone') }}"></div>
                <div class="field"><label>Email</label><input type="email" name="contact[email]" value="{{ $c('email') }}"></div>
                <div class="field field--full"><label>Office hours</label><input type="text" name="contact[hours]" value="{{ $c('hours') }}"></div>
            </div>
        </div>

        <div class="panel">
            <h2>Social links</h2>
            <div class="form-grid">
                <div class="field"><label>Facebook</label><input type="url" name="social[facebook]" value="{{ $s('facebook') }}"></div>
                <div class="field"><label>Instagram</label><input type="url" name="social[instagram]" value="{{ $s('instagram') }}"></div>
                <div class="field"><label>YouTube</label><input type="url" name="social[youtube]" value="{{ $s('youtube') }}"></div>
                <div class="field"><label>LinkedIn</label><input type="url" name="social[linkedin]" value="{{ $s('linkedin') }}"></div>
            </div>
        </div>

        <div class="panel">
            <h2>Headline stats <span class="hint muted">(the four figures on the maroon band)</span></h2>
            <div class="form-grid">
                @for ($i = 0; $i < 4; $i++)
                    <div class="field">
                        <label>Stat {{ $i + 1 }}</label>
                        <input type="text" name="stats[{{ $i }}][value]" placeholder="Value (e.g. 2,400+)"
                               value="{{ old("stats.$i.value", data_get($stats, "$i.value")) }}" style="margin-bottom:.4rem">
                        <input type="text" name="stats[{{ $i }}][label]" placeholder="Label (e.g. Registered members)"
                               value="{{ old("stats.$i.label", data_get($stats, "$i.label")) }}">
                    </div>
                @endfor
            </div>
        </div>

        <div class="panel">
            <h2>Home page message</h2>
            <div class="form-grid">
                <div class="field"><label>Name</label><input type="text" name="message[name]" value="{{ $m('name') }}"></div>
                <div class="field"><label>Title</label><input type="text" name="message[title]" value="{{ $m('title') }}"></div>
                <div class="field"><label>Batch / year <span class="hint">(optional)</span></label><input type="text" name="message[batch]" value="{{ $m('batch') }}"></div>
                <div class="field">
                    <label>Photo <span class="hint">(portrait; leave blank to keep)</span></label>
                    <input type="file" name="message[photo]" accept="image/*">
                    @if (data_get($message, 'photo'))
                        <div class="field-preview"><img src="{{ asset(data_get($message, 'photo')) }}" alt=""><span class="muted">Current</span></div>
                    @endif
                </div>
                <div class="field field--full">
                    <label>Message <span class="hint">(separate paragraphs with a blank line)</span></label>
                    <textarea name="message[body]" style="min-height:180px">{{ old('message.body', is_array(data_get($message, 'body')) ? implode("\n\n", data_get($message, 'body')) : data_get($message, 'body')) }}</textarea>
                </div>
            </div>
        </div>

        <div class="panel">
            <h2>Current Funds <span class="hint muted">(shown on the member dashboard's "Current Funds" tab)</span></h2>
            <p class="muted">
                The total balance and fund breakdown are now calculated automatically from every addition and
                deduction recorded at <a href="{{ route('admin.funds.index') }}">Funds</a> — there's nothing to
                edit here any more.
            </p>
            <a href="{{ route('admin.funds.index') }}" class="btn btn--ghost btn--sm">Manage fund transactions →</a>
        </div>

        <div class="panel">
            <h2>Donations <span class="hint muted">(shown on the member dashboard's "Donations" tab)</span></h2>
            <div class="form-grid">
                <div class="field field--full">
                    <label>Introduction</label>
                    <textarea name="donations[intro]" style="min-height:90px">{{ $dn('intro') }}</textarea>
                </div>
                <div class="field"><label>Bank name</label><input type="text" name="donations[bank_name]" value="{{ $dn('bank_name') }}"></div>
                <div class="field"><label>Account name</label><input type="text" name="donations[account_name]" value="{{ $dn('account_name') }}"></div>
                <div class="field"><label>Account number</label><input type="text" name="donations[account_number]" value="{{ $dn('account_number') }}"></div>
                <div class="field"><label>Branch</label><input type="text" name="donations[branch]" value="{{ $dn('branch') }}"></div>
            </div>
        </div>

        <div class="form-actions" style="border:0">
            <button class="btn btn--primary">Save all settings</button>
        </div>
    </form>
@endsection
