<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CommitteeMember extends Model
{
    protected $fillable = ['group', 'role', 'name', 'photo', 'sort'];

    protected $casts = ['sort' => 'integer'];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function scopeOfficeBearers(Builder $query): Builder
    {
        return $query->where('group', 'office_bearer')->ordered();
    }

    public function scopeMembers(Builder $query): Builder
    {
        return $query->where('group', 'member')->ordered();
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.content'));
        static::deleted(fn () => Cache::forget('site.content'));
    }
}
