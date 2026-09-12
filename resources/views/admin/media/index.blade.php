@extends('admin.layout')
@section('title', 'Gallery & Hero')
@section('heading', 'Gallery & Hero images')
@section('subheading', 'Hero images rotate in the homepage banner. Gallery images fill the “In pictures” grid.')

@section('content')
    @foreach ([
        ['hero', 'Homepage hero', 'These crossfade behind the headline. 3–5 wide photos work best.', false],
        ['gallery', 'Homepage gallery', 'Shown in the “Best moment of Dutugemunu” grid.', true],
    ] as [$collection, $label, $hint, $withCaption])
        <div class="panel">
            <div class="panel__head">
                <h2>{{ $label }}</h2>
                <span class="muted">{{ ${$collection}->count() }} image{{ ${$collection}->count() === 1 ? '' : 's' }}</span>
            </div>
            <p class="muted" style="margin-top:-.4rem">{{ $hint }}</p>

            @if (${$collection}->isNotEmpty())
                <div class="table-scroll">
                    <table class="table">
                        <thead>
                            <tr><th></th>@if ($withCaption)<th>Caption</th><th>Size</th>@endif<th>Order</th><th></th></tr>
                        </thead>
                        <tbody>
                        @foreach (${$collection} as $item)
                            <tr>
                                <td><img src="{{ asset($item->path) }}" class="thumb thumb--wide" alt=""></td>
                                <form method="POST" action="{{ route('admin.media.update', $item) }}" id="m{{ $item->id }}">@csrf @method('PUT')</form>
                                @if ($withCaption)
                                    <td><input form="m{{ $item->id }}" type="text" name="caption" value="{{ $item->caption }}" style="width:100%;padding:.4rem .5rem;border:1px solid #d3cabb;border-radius:5px"></td>
                                    <td>
                                        <select form="m{{ $item->id }}" name="size_class" style="padding:.4rem;border:1px solid #d3cabb;border-radius:5px">
                                            <option value="" @selected(!$item->size_class)>Normal</option>
                                            <option value="wide" @selected($item->size_class === 'wide')>Wide</option>
                                            <option value="tall" @selected($item->size_class === 'tall')>Tall</option>
                                        </select>
                                    </td>
                                @endif
                                <td><input form="m{{ $item->id }}" type="number" name="sort" value="{{ $item->sort }}" min="0" style="width:64px;padding:.4rem;border:1px solid #d3cabb;border-radius:5px"></td>
                                <td>
                                    <div class="row-actions">
                                        <button form="m{{ $item->id }}" class="btn btn--ghost btn--sm">Save</button>
                                        <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="inline-form" onsubmit="return confirm('Remove this image?')">
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

            <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="mt"
                  style="display:flex;gap:.7rem;flex-wrap:wrap;align-items:flex-end">
                @csrf
                <input type="hidden" name="collection" value="{{ $collection }}">
                <div class="field" style="margin:0">
                    <label>Add an image</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                @if ($withCaption)
                    <div class="field" style="margin:0">
                        <label>Caption</label>
                        <input type="text" name="caption">
                    </div>
                @endif
                <button class="btn btn--primary">Upload</button>
            </form>
        </div>
    @endforeach
@endsection
