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
