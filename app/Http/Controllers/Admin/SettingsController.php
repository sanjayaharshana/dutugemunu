<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\HandlesUploads;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        return view('admin.settings.edit', [
            'general'   => Setting::group('general'),
            'contact'   => Setting::group('contact'),
            'social'    => Setting::group('social'),
            'stats'     => array_pad(Setting::group('stats'), 4, ['value' => '', 'label' => '']),
            'message'   => Setting::group('president_message'),
            'donations' => Setting::group('donations'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'general.name'        => ['required', 'string', 'max:160'],
            'general.short_name'  => ['nullable', 'string', 'max:40'],
            'general.college'     => ['nullable', 'string', 'max:120'],
            'general.location'    => ['nullable', 'string', 'max:120'],
            'general.motto'       => ['nullable', 'string', 'max:160'],
            'general.motto_si'    => ['nullable', 'string', 'max:160'],
            'general.founded'     => ['nullable', 'string', 'max:12'],
            'general.oba_founded' => ['nullable', 'string', 'max:12'],

            'contact.address' => ['nullable', 'string', 'max:255'],
            'contact.phone'   => ['nullable', 'string', 'max:60'],
            'contact.email'   => ['nullable', 'email', 'max:120'],
            'contact.hours'   => ['nullable', 'string', 'max:160'],

            'social.facebook'  => ['nullable', 'url', 'max:255'],
            'social.instagram' => ['nullable', 'url', 'max:255'],
            'social.youtube'   => ['nullable', 'url', 'max:255'],
            'social.linkedin'  => ['nullable', 'url', 'max:255'],

            'stats'         => ['array'],
            'stats.*.value' => ['nullable', 'string', 'max:40'],
            'stats.*.label' => ['nullable', 'string', 'max:60'],

            'message.name'   => ['nullable', 'string', 'max:160'],
            'message.title'  => ['nullable', 'string', 'max:160'],
            'message.batch'  => ['nullable', 'string', 'max:60'],
            'message.body'   => ['nullable', 'string'],
            'message.photo'  => ['nullable', 'image', 'max:6144'],

            'donations.intro'          => ['nullable', 'string', 'max:800'],
            'donations.bank_name'      => ['nullable', 'string', 'max:120'],
            'donations.account_name'   => ['nullable', 'string', 'max:160'],
            'donations.account_number' => ['nullable', 'string', 'max:60'],
            'donations.branch'         => ['nullable', 'string', 'max:120'],
        ]);

        Setting::put('general', $data['general']);
        Setting::put('contact', array_map(fn ($v) => $v ?? '', $data['contact'] ?? []));
        Setting::put('social', array_map(fn ($v) => $v ?? '', $data['social'] ?? []));

        Setting::put('stats', collect($data['stats'] ?? [])
            ->filter(fn ($s) => filled($s['value'] ?? null) || filled($s['label'] ?? null))
            ->map(fn ($s) => ['value' => (string) ($s['value'] ?? ''), 'label' => (string) ($s['label'] ?? '')])
            ->values()->all());

        $message = Setting::group('president_message');
        $message['name']  = $data['message']['name'] ?? '';
        $message['title'] = $data['message']['title'] ?? '';
        $message['batch'] = $data['message']['batch'] ?? '';
        $message['body']  = collect(preg_split('/\R{2,}/', trim((string) $request->input('message.body'))))
            ->map(fn ($p) => trim(preg_replace('/\s*\R\s*/', ' ', $p)))
            ->filter()->values()->all();

        if ($request->hasFile('message.photo')) {
            $this->deleteImage($message['photo'] ?? null);
            $message['photo'] = $this->storeImage($request->file('message.photo'), 'people');
        }

        Setting::put('president_message', $message);

        Setting::put('donations', array_map(fn ($v) => $v ?? '', $data['donations'] ?? []));

        return back()->with('status', 'Settings saved.');
    }
}
