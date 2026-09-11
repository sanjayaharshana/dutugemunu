<?php

namespace App\Support;

use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\NewsArticle;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Assembles the site's `association` content array from the database,
 * falling back to config/association.php for anything not yet stored.
 *
 * The result is merged into the `association` config key at boot, so every
 * existing `config('association.*')` call transparently reads live data.
 */
class SiteContent
{
    public static function all(): array
    {
        // During install / before migration, just use the config defaults.
        if (! self::ready()) {
            return config('association', []);
        }

        return Cache::rememberForever('site.content', fn () => self::build());
    }

    public static function forget(): void
    {
        Cache::forget('site.content');
        Setting::flushCache();
    }

    protected static function ready(): bool
    {
        try {
            return Schema::hasTable('settings') && Schema::hasTable('committee_members');
        } catch (\Throwable) {
            return false;
        }
    }

    protected static function build(): array
    {
        $defaults = config('association', []);

        $general = Setting::group('general');
        $contact = Setting::group('contact', $defaults['contact'] ?? []);
        $social  = Setting::group('social', $defaults['social'] ?? []);
        $stats   = Setting::group('stats', $defaults['stats'] ?? []);
        $message = Setting::group('president_message', $defaults['president_message'] ?? []);

        $data = array_merge($defaults, array_filter([
            'name'        => $general['name'] ?? null,
            'short_name'  => $general['short_name'] ?? null,
            'college'     => $general['college'] ?? null,
            'location'    => $general['location'] ?? null,
            'motto'       => $general['motto'] ?? null,
            'motto_si'    => $general['motto_si'] ?? null,
            'founded'     => $general['founded'] ?? null,
            'oba_founded' => $general['oba_founded'] ?? null,
        ], fn ($v) => $v !== null && $v !== ''));

        $data['contact']           = array_merge($defaults['contact'] ?? [], $contact);
        $data['social']            = array_merge($defaults['social'] ?? [], $social);
        $data['stats']             = ! empty($stats) ? array_values($stats) : ($defaults['stats'] ?? []);
        $data['president_message'] = array_merge($defaults['president_message'] ?? [], $message);

        $data['news'] = NewsArticle::query()->published()->newest()->get()
            ->map(fn (NewsArticle $a) => [
                'slug'    => $a->slug,
                'date'    => optional($a->published_at)->toDateString(),
                'tag'     => $a->tag,
                'title'   => $a->title,
                'image'   => $a->image,
                'excerpt' => $a->excerpt,
                'body'    => $a->body ?? [],
            ])->all();

        $data['events'] = Event::query()->upcoming()->get()
            ->map(fn (Event $e) => [
                'date'     => $e->date->toDateString(),
                'title'    => $e->title,
                'location' => $e->location,
                'time'     => $e->time,
                'text'     => $e->description,
            ])->all();

        $data['past_events'] = Event::query()->past()->get()
            ->map(fn (Event $e) => [
                'date'  => $e->date->toDateString(),
                'title' => $e->title,
                'text'  => $e->description,
            ])->all();

        $bearers = CommitteeMember::query()->officeBearers()->get();
        $members = CommitteeMember::query()->members()->get();

        $data['committee'] = array_merge($defaults['committee'] ?? [], [
            'office_bearers' => $bearers->map(fn (CommitteeMember $m) => [
                'role'  => $m->role,
                'name'  => $m->name,
                'photo' => $m->photo,
            ])->all(),
            'members' => $members->map(fn (CommitteeMember $m) => [
                'name'  => $m->name,
                'photo' => $m->photo,
            ])->all(),
        ]);

        $data['gallery'] = MediaItem::query()->collection('gallery')->get()
            ->map(fn (MediaItem $m) => [
                'path'    => $m->path,
                'caption' => $m->caption,
                'size'    => $m->size_class,
            ])->all();

        $data['hero'] = MediaItem::query()->collection('hero')->get()
            ->pluck('path')->all();

        return $data;
    }
}
