@extends('admin.layout')
@section('title', 'Members')
@section('heading', 'Registered Members')
@section('subheading', 'Everyone who has registered through the "Become a Member" wizard on the public site.')

@section('content')
    <div class="panel">
        @if ($members->isEmpty())
            <p class="muted">No one has registered yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr><th>Name</th><th>NIC</th><th>Phone</th><th>Batch left</th><th>Joined</th><th></th></tr>
                </thead>
                <tbody>
                @foreach ($members as $m)
                    <tr>
                        <td><a href="{{ route('admin.members.show', $m) }}"><strong>{{ $m->full_name }}</strong></a></td>
                        <td class="muted">{{ $m->nic }}</td>
                        <td class="muted">{{ $m->phone }}</td>
                        <td class="muted">{{ $m->year_left }}</td>
                        <td class="muted">{{ $m->created_at->format('j M Y') }}</td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.members.show', $m) }}" class="btn btn--ghost btn--sm">View</a>
                                <form method="POST" action="{{ route('admin.members.destroy', $m) }}" class="inline-form"
                                      onsubmit="return confirm('Remove {{ addslashes($m->full_name) }}\'s membership record?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn--danger btn--sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
