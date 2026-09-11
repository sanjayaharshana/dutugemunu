<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.news.index', [
            'articles' => NewsArticle::orderByDesc('published_at')->orderByDesc('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.news.form', ['article' => new NewsArticle(['published_at' => now()])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'), 'news');
        }

        NewsArticle::create($data);

        return redirect()->route('admin.news.index')->with('status', 'Article created.');
    }

    public function edit(NewsArticle $news)
    {
        return view('admin.news.form', ['article' => $news]);
    }

    public function update(Request $request, NewsArticle $news)
    {
        $data = $this->validated($request, $news);

        if ($request->hasFile('image')) {
            $this->deleteImage($news->image);
            $data['image'] = $this->storeImage($request->file('image'), 'news');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('status', 'Article updated.');
    }

    public function destroy(NewsArticle $news)
    {
        $this->deleteImage($news->image);
        $news->delete();

        return redirect()->route('admin.news.index')->with('status', 'Article deleted.');
    }

    protected function validated(Request $request, ?NewsArticle $article = null): array
    {
        $v = $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'slug'         => ['nullable', 'string', 'max:200', 'alpha_dash', Rule::unique('news_articles', 'slug')->ignore($article?->id)],
            'tag'          => ['nullable', 'string', 'max:60'],
            'excerpt'      => ['nullable', 'string', 'max:400'],
            'body'         => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'image'        => ['nullable', 'image', 'max:6144'],
        ]);

        $v['slug'] = $v['slug'] ?: Str::slug($v['title']);
        $v['body'] = collect(preg_split('/\R{2,}/', trim((string) $request->input('body'))))
            ->map(fn ($p) => trim(preg_replace('/\s*\R\s*/', ' ', $p)))
            ->filter()
            ->values()
            ->all();
        $v['published_at'] = $request->filled('published_at') ? Carbon::parse($v['published_at']) : null;

        unset($v['image']);

        return $v;
    }
}
