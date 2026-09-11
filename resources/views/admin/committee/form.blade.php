@extends('admin.layout')
@section('title', $member->exists ? 'Edit member' : 'Add member')
@section('heading', $member->exists ? 'Edit — ' . $member->name : 'Add committee member')

@section('content')
    <form class="panel" method="POST"
          action="{{ $member->exists ? route('admin.committee.update', $member) : route('admin.committee.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if ($member->exists) @method('PUT') @endif

        <div class="form-grid">
            <div class="field">
                <label for="group">Section</label>
                <select name="group" id="group">
                    <option value="office_bearer" @selected(old('group', $member->group) === 'office_bearer')>Office Bearer</option>
                    <option value="member" @selected(old('group', $member->group) === 'member')>Executive Committee Member</option>
                </select>
            </div>
            <div class="field">
                <label for="role">Role / position <span class="hint">(office bearers only, e.g. “Secretary”)</span></label>
                <input type="text" name="role" id="role" value="{{ old('role', $member->role) }}">
                @error('role')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field field--full">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" required>
                @error('name')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field field--full">
                <label for="photo">Photo <span class="hint">(square works best; JPG/PNG up to 6 MB. Leave blank to keep current.)</span></label>
                <input type="file" name="photo" id="photo" accept="image/*">
                @error('photo')<div class="err">{{ $message }}</div>@enderror
                @if ($member->photo)
                    <div class="field-preview">
                        <img src="{{ asset($member->photo) }}" alt="">
                        <span class="muted">Current photo</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn--primary">Save</button>
            <a href="{{ route('admin.committee.index') }}" class="btn btn--ghost">Cancel</a>
        </div>
    </form>
@endsection
