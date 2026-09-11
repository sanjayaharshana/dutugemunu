@extends('admin.layout')
@section('title', 'Committee')
@section('heading', 'The Committee')
@section('subheading', 'Office bearers and executive committee members shown on the Committee page.')

@section('content')
    <div class="panel">
        <div class="panel__head">
            <h2>Office Bearers</h2>
            <a href="{{ route('admin.committee.create', ['group' => 'office_bearer']) }}" class="btn btn--primary btn--sm">+ Add office bearer</a>
        </div>
        @include('admin.committee._grid', ['people' => $officeBearers, 'showRole' => true])
    </div>

    <div class="panel">
        <div class="panel__head">
            <h2>Executive Committee Members</h2>
            <a href="{{ route('admin.committee.create', ['group' => 'member']) }}" class="btn btn--primary btn--sm">+ Add member</a>
        </div>
        @include('admin.committee._grid', ['people' => $members, 'showRole' => false])
    </div>
@endsection
