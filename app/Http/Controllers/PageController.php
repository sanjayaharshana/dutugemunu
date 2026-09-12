<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'news'   => $this->newsItems()->take(3),
            'events' => $this->upcomingEvents()->take(3),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function committee()
    {
        return view('pages.committee');
    }

    public function news()
    {
        return view('pages.news', [
            'news'       => $this->newsItems(),
            'events'     => $this->upcomingEvents(),
            'pastEvents' => collect(config('association.past_events'))
                ->sortByDesc('date')->values(),
        ]);
    }

    public function newsShow(string $slug)
    {
        $all = $this->newsItems();

        $article = $all->firstWhere('slug', $slug);

        abort_if($article === null, 404);

        return view('pages.news-show', [
            'article' => $article,
            'more'    => $all->where('slug', '!=', $slug)->take(3)->values(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function downloads()
    {
        $downloads = collect(config('association.downloads', []))
            ->map(function (array $d) {
                $path = public_path($d['file']);

                $d['exists']     = is_file($path);
                $d['url']        = $this->publicFileUrl($d['file']);
                $d['size_label'] = $d['exists'] ? $this->humanFileSize(filesize($path)) : null;

                return $d;
            });

        return view('pages.downloads', ['downloads' => $downloads]);
    }

    /**
     * asset() doesn't encode spaces/special characters in the path itself,
     * so file names like "Dutugemunu Old St.pdf" need each segment encoded.
     */
    private function publicFileUrl(string $relativePath): string
    {
        $encoded = implode('/', array_map('rawurlencode', explode('/', $relativePath)));

        return asset($encoded);
    }

    private function humanFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024) . ' KB';
        }

        return $bytes . ' B';
    }

    /**
     * News items, newest first, each with a Carbon date attached.
     */
    private function newsItems(): Collection
    {
        return collect(config('association.news'))
            ->map(function (array $item) {
                $item['date'] = Carbon::parse($item['date']);

                return $item;
            })
            ->sortByDesc(fn (array $item) => $item['date'])
            ->values();
    }

    /**
     * Upcoming events only, soonest first.
     */
    private function upcomingEvents(): Collection
    {
        return collect(config('association.events'))
            ->map(function (array $item) {
                $item['date'] = Carbon::parse($item['date']);

                return $item;
            })
            ->sortBy(fn (array $item) => $item['date'])
            ->values();
    }
}
