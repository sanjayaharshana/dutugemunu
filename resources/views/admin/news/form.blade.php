@extends('admin.layout')
@section('title', $article->exists ? 'Edit article' : 'New article')
@section('heading', $article->exists ? 'Edit article' : 'New article')

@section('content')
    <form class="panel" method="POST"
          action="{{ $article->exists ? route('admin.news.update', $article) : route('admin.news.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if ($article->exists) @method('PUT') @endif

        <div class="form-grid">
            <div class="field field--full">
                <label for="title">Headline</label>
                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required>
                @error('title')<div class="err">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="slug">URL slug <span class="hint">(auto from the headline if left blank)</span></label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}" placeholder="e.g. annual-dinner-2027">
                @error('slug')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="tag">Tag <span class="hint">(e.g. Announcement, Projects, Sports)</span></label>
                <input type="text" name="tag" id="tag" value="{{ old('tag', $article->tag) }}">
            </div>

            <div class="field">
                <label for="published_at">Publish date <span class="hint">(blank = draft)</span></label>
                <input type="date" name="published_at" id="published_at"
                       value="{{ old('published_at', optional($article->published_at)->format('Y-m-d')) }}">
            </div>
            <div class="field">
                <label for="image">Cover image <span class="hint">(landscape; up to 6 MB)</span></label>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image')<div class="err">{{ $message }}</div>@enderror
                @if ($article->image)
                    <div class="field-preview"><img src="{{ asset($article->image) }}" alt=""><span class="muted">Current</span></div>
                @endif
            </div>

            <div class="field field--full">
                <label for="excerpt">Summary <span class="hint">(one or two sentences, shown in listings)</span></label>
                <textarea name="excerpt" id="excerpt" style="min-height:70px">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            <div class="field field--full">
                <label for="body">Article <span class="hint">(separate paragraphs with a blank line)</span></label>
                <textarea name="body" id="body" style="min-height:220px">{{ old('body', is_array($article->body) ? implode("\n\n", $article->body) : $article->body) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn--primary">Save</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn--ghost">Cancel</a>
            @if ($article->exists)
                <a href="{{ route('news.show', $article->slug) }}" target="_blank" rel="noopener" class="btn btn--link">Preview ↗</a>
            @endif
        </div>
    </form>
@endsection
