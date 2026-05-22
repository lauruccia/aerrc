<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Partner extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name', 'slug', 'logo_url', 'website_url', 'contact_email',
        'category', 'tier',
        'is_active', 'is_featured_homepage', 'sort_order',
        'description_it', 'description_en',
    ];

    protected $casts = [
        'is_active'            => 'boolean',
        'is_featured_homepage' => 'boolean',
        'sort_order'           => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // ── Scopes ──────────────────────────────────────────────────
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured_homepage', true);
    }

    // ── Label helpers ────────────────────────────────────────────
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'airline'      => '✈️ Compagnia Aerea',
            'hotel'        => '🏨 Hotel / Ricettività',
            'tour_operator'=> '🗺️ Tour Operator',
            'institution'  => '🏛️ Ente Pubblico',
            'media'        => '📺 Media Partner',
            'service'      => '🔧 Servizi',
            default        => '🤝 Altro',
        };
    }

    public function getTierLabelAttribute(): string
    {
        return match ($this->tier) {
            'gold'     => '🥇 Gold',
            'silver'   => '🥈 Silver',
            'bronze'   => '🥉 Bronze',
            default    => '🤝 Standard',
        };
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_it;
    }
}
