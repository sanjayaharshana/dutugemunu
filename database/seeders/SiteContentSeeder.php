<?php

namespace Database\Seeders;

use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\NewsArticle;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        // Read the original config file directly — by the time this runs the
        // `association` config key has already been swapped for the (empty) DB view.
        $c = require config_path('association.php');

        $this->seedSettings($c);
        $this->seedCommittee($c);
        $this->seedNews($c);
        $this->seedEvents($c);
        $this->seedMedia();
    }

    protected function seedSettings(array $c): void
    {
        Setting::put('general', [
            'name'        => $c['name'],
            'short_name'  => $c['short_name'],
            'college'     => $c['college'],
            'location'    => $c['location'] ?? 'Buttala',
            'motto'       => $c['motto'],
            'motto_si'    => $c['motto_si'],
            'founded'     => (string) $c['founded'],
            'oba_founded' => (string) $c['oba_founded'],
        ]);

        Setting::put('contact', $c['contact']);
        Setting::put('social', $c['social']);
        Setting::put('stats', $c['stats']);
        Setting::put('president_message', $c['president_message']);
    }

    protected function seedCommittee(array $c): void
    {
        if (CommitteeMember::query()->exists()) {
            return;
        }

        foreach (array_values($c['committee']['office_bearers']) as $i => $p) {
            CommitteeMember::create([
                'group' => 'office_bearer',
                'role'  => $p['role'] ?? null,
                'name'  => $p['name'],
                'photo' => $p['photo'] ?? null,
                'sort'  => $i,
            ]);
        }

        foreach (array_values($c['committee']['members']) as $i => $p) {
            CommitteeMember::create([
                'group' => 'member',
                'name'  => is_array($p) ? $p['name'] : $p,
                'photo' => is_array($p) ? ($p['photo'] ?? null) : null,
                'sort'  => $i,
            ]);
        }
    }

    protected function seedNews(array $c): void
    {
        if (NewsArticle::query()->exists()) {
            return;
        }

        foreach (array_values($c['news']) as $i => $n) {
            NewsArticle::create([
                'slug'         => $n['slug'],
                'title'        => $n['title'],
                'tag'          => $n['tag'] ?? null,
                'excerpt'      => $n['excerpt'] ?? null,
                'body'         => $n['body'] ?? [],
                'image'        => $n['image'] ?? null,
                'published_at' => Carbon::parse($n['date']),
                'sort'         => $i,
            ]);
        }
    }

    protected function seedEvents(array $c): void
    {
        if (Event::query()->exists()) {
            return;
        }

        foreach (array_values($c['events']) as $i => $e) {
            Event::create([
                'title'       => $e['title'],
                'date'        => Carbon::parse($e['date']),
                'location'    => $e['location'] ?? null,
                'time'        => $e['time'] ?? null,
                'description' => $e['text'] ?? null,
                'sort'        => $i,
            ]);
        }

        foreach (array_values($c['past_events'] ?? []) as $i => $e) {
            Event::create([
                'title'       => $e['title'],
                'date'        => Carbon::parse($e['date']),
                'location'    => $e['location'] ?? null,
                'time'        => $e['time'] ?? null,
                'description' => $e['text'] ?? null,
                'sort'        => $i,
            ]);
        }
    }

    protected function seedMedia(): void
    {
        if (MediaItem::query()->exists()) {
            return;
        }

        $gallery = [
            ['g1.svg', 'Prize Giving', 'wide'],
            ['g2.svg', 'Annual Dinner', 'tall'],
            ['g3.svg', 'Annual Encounter', ''],
            ['g4.svg', "Founders' Day", ''],
            ['g5.svg', 'Family Fun Day', ''],
            ['g6.svg', 'Colombo Reunion', 'wide'],
            ['g7.svg', 'Library Project', ''],
            ['g8.svg', 'Sports Meet', ''],
        ];
        foreach ($gallery as $i => [$file, $caption, $size]) {
            MediaItem::create([
                'collection' => 'gallery',
                'path'       => 'images/gallery/' . $file,
                'caption'    => $caption,
                'size_class' => $size ?: null,
                'sort'       => $i,
            ]);
        }

        foreach (['campus.webp', 'avenue.webp', 'shrine.webp', 'road.webp'] as $i => $file) {
            MediaItem::create([
                'collection' => 'hero',
                'path'       => 'hero/' . $file,
                'sort'       => $i,
            ]);
        }
    }
}
