<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'subscribed_at', 'locale', 'is_active'];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'is_active'     => 'boolean',
    ];
}
