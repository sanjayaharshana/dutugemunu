@if ($people->isEmpty())
    <p class="muted">Nobody added yet.</p>
@else
    <div class="people-grid">
        @foreach ($people as $person)
            <div class="people-card">
                <img src="{{ $person->photo ? asset($person->photo) : asset('images/people/m1.svg') }}" alt="">
                <div class="people-card__b">
                    @if ($showRole)<div class="role">{{ $person->role ?: 'Office Bearer' }}</div>@endif
                    <div class="name">{{ $person->name }}</div>
                    <div class="acts">
                        <a href="{{ route('admin.committee.edit', $person) }}" class="btn btn--ghost btn--sm">Edit</a>
                        <form method="POST" action="{{ route('admin.committee.destroy', $person) }}" class="inline-form"
                              onsubmit="return confirm('Remove {{ addslashes($person->name) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn--danger btn--sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
