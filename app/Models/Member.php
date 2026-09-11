<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Member extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'permanent_address',
        'phone',
        'nic',
        'workplace_address_phone',
        'occupation',
        'admission_number',
        'year_left',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Cumulative registered-member count, one point per month, for the "Members
     * Growth" line chart. Starts one month before the first-ever registration
     * (anchored at 0) so even a single month of history plots a real line.
     * Returns ['labels' => [...], 'values' => [...]], both empty if there are no members yet.
     */
    public static function growthSeries(): array
    {
        $first = static::query()->min('created_at');

        if (! $first) {
            return ['labels' => [], 'values' => []];
        }

        $byMonth = static::query()->pluck('created_at')
            ->map(fn ($d) => Carbon::parse($d)->format('Y-m'))
            ->countBy();

        $cursor = Carbon::parse($first)->startOfMonth()->subMonth();
        $end = Carbon::now()->startOfMonth();

        $labels = [];
        $values = [];
        $cumulative = 0;

        while ($cursor->lte($end)) {
            $cumulative += $byMonth->get($cursor->format('Y-m'), 0);
            $labels[] = $cursor->format('M Y');
            $values[] = $cumulative;
            $cursor->addMonth();
        }

        return ['labels' => $labels, 'values' => $values];
    }
}
