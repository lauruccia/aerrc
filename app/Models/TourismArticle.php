<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class TourismArticle extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title_it', 'title_en', 'title_de', 'title_fr',
        'slug', 'excerpt_it', 'excerpt_en', 'excerpt_de', 'excerpt_fr',
        'body_it', 'body_en', 'body_de', 'body_fr',
        'category', 'color_from', 'color_to',
        'is_published', 'is_featured', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title_it')
            ->saveSlugsTo('slug');
    }

    // ── Scopes ──────────────────────────────────────────────
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // ── Accessors localizzati ────────────────────────────────
    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"title_{$locale}"} ?? $this->title_it ?? '';
    }

    public function getExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"excerpt_{$locale}"} ?? $this->excerpt_it;
    }

    public function getBodyAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"body_{$locale}"} ?? $this->body_it;
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'natura'    => '🌿 Natura',
            'storia'    => '🏛️ Storia',
            'gastronomia' => '🍝 Gastronomia',
            'mare'      => '🏖️ Mare',
            'borghi'    => '🏘️ Borghi',
            'eventi'    => '🎭 Eventi',
            default     => ucfirst($this->category ?? ''),
        };
    }
}
