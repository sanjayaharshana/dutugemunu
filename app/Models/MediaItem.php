<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MediaItem extends Model
{
    protected $fillable = ['collection', 'path', 'caption', 'size_class', 'sort'];

    protected $casts = ['sort' => 'integer'];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function scopeCollection(Builder $query, string $collection): Builder
    {
        return $query->where('collection', $collection)->ordered();
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.content'));
        static::deleted(fn () => Cache::forget('site.content'));
    }
}
