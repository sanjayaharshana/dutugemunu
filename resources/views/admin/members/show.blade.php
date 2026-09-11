@extends('admin.layout')
@section('title', $member->full_name)
@section('heading', $member->full_name)
@section('subheading', 'Registered ' . $member->created_at->format('j F Y'))
@section('actions')
    <a href="{{ route('admin.members.index') }}" class="btn btn--ghost">&larr; All members</a>
@endsection

@section('content')
    <div class="panel">
        <div class="form-grid">
            <div class="field"><label>Full Name</label><p>{{ $member->full_name }}</p></div>
            <div class="field"><label>NIC Number</label><p>{{ $member->nic }}</p></div>
            <div class="field"><label>Phone Number</label><p>{{ $member->phone }}</p></div>
            <div class="field"><label>Current Occupation</label><p>{{ $member->occupation ?: '—' }}</p></div>
            <div class="field field--full"><label>Permanent Address</label><p>{{ $member->permanent_address }}</p></div>
            <div class="field field--full"><label>Workplace Address &amp; Phone</label><p>{{ $member->workplace_address_phone ?: '—' }}</p></div>
            <div class="field"><label>School Admission Number</label><p>{{ $member->admission_number }}</p></div>
            <div class="field"><label>Year Left School</label><p>{{ $member->year_left }}</p></div>
        </div>

        <div class="form-actions">
            <form method="POST" action="{{ route('admin.members.destroy', $member) }}"
                  onsubmit="return confirm('Remove {{ addslashes($member->full_name) }}\'s membership record? This cannot be undone.')">
                @csrf @method('DELETE')
                <button class="btn btn--danger">Delete this membership record</button>
            </form>
        </div>
    </div>
@endsection
