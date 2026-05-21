<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Destination extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'city', 'country', 'iata_code', 'flag_emoji',
        'slug', 'price_from', 'color_from', 'color_to',
        'airlines_string', 'is_active', 'sort_order',
        'description_it', 'description_en', 'description_de', 'description_fr',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'price_from' => 'decimal:2',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('city')
            ->saveSlugsTo('slug');
    }

    // ── Scopes ──────────────────────────────────────────────
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ── Accessors ───────────────────────────────────────────
    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->{"description_{$locale}"} ?? $this->description_it;
    }
}
