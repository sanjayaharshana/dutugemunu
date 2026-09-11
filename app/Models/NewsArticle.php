<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class NewsArticle extends Model
{
    protected $fillable = ['slug', 'title', 'tag', 'excerpt', 'body', 'image', 'published_at', 'sort'];

    protected $casts = [
        'body' => 'array',
        'published_at' => 'datetime',
        'sort' => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.content'));
        static::deleted(fn () => Cache::forget('site.content'));
    }
}
