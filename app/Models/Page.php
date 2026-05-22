<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title_it', 'title_en', 'title_de', 'title_fr',
        'content_it', 'content_en', 'content_de', 'content_fr',
        'meta_title_it', 'meta_title_en',
        'meta_desc_it', 'meta_desc_en',
        'is_active',
        'show_in_footer',
        'sort_order',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'show_in_footer' => 'boolean',
    ];

    public function getTitle(string $locale = 'it'): string
    {
        return $this->{"title_{$locale}"} ?? $this->title_it ?? '';
    }

    public function getContent(string $locale = 'it'): string
    {
        return $this->{"content_{$locale}"} ?? $this->content_it ?? '';
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }

    public static function footerPages()
    {
        return static::where('is_active', true)
            ->where('show_in_footer', true)
            ->orderBy('sort_order')
            ->get();
    }
}
