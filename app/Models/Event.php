<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Event extends Model
{
    protected $fillable = ['title', 'date', 'location', 'time', 'description', 'sort'];

    protected $casts = [
        'date' => 'date',
        'sort' => 'integer',
    ];

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('date', '>=', today())
            ->orderBy('sort')->orderBy('date');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->whereDate('date', '<', today())->orderByDesc('date');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.content'));
        static::deleted(fn () => Cache::forget('site.content'));
    }
}
