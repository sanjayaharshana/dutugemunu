<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A message sent through the public "Write to the Secretary" form on the Contact page. */
class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'year', 'topic', 'message'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
