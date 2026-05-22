<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'author_name', 'author_role', 'author_avatar',
        'text_it', 'text_en', 'text_de', 'text_fr',
        'stars', 'source', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stars'     => 'integer',
    ];

    public function getText(string $locale = 'it'): string
    {
        return $this->{"text_{$locale}"} ?? $this->text_it ?? '';
    }

    public static function sources(): array
    {
        return [
            'sito'        => '🌐 Sito web',
            'google'      => '🔍 Google Reviews',
            'tripadvisor' => '🦉 TripAdvisor',
            'facebook'    => '👍 Facebook',
        ];
    }
}
