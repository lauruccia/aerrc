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
        // Tipo articolo
        'post_type',
        // Contenuto multilingua
        'title_it', 'title_en', 'title_de', 'title_fr',
        'slug',
        'excerpt_it', 'excerpt_en', 'excerpt_de', 'excerpt_fr',
        'body_it', 'body_en', 'body_de', 'body_fr',
        // Aspetto
        'category', 'color_from', 'color_to', 'image_url',
        // Pubblicazione
        'is_published', 'is_featured', 'is_breaking', 'published_at',
        'author', 'source', 'reading_time',
        // SEO
        'seo_title_it', 'seo_title_en',
        'seo_description_it', 'seo_description_en',
        'focus_keyword', 'og_image', 'canonical_url', 'robots',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'is_breaking'  => 'boolean',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
    ];

    // ── Costanti tipo articolo ───────────────────────────────────
    const TYPE_TOURISM = 'tourism';
    const TYPE_NEWS    = 'news';
    const TYPE_CITY    = 'city';
    const TYPE_GUIDE   = 'guide';

    public static function postTypes(): array
    {
        return [
            self::TYPE_TOURISM => '🏖️ Turismo',
            self::TYPE_NEWS    => '📰 Notizie',
            self::TYPE_CITY    => '🏙️ Città',
            self::TYPE_GUIDE   => '📖 Guide',
        ];
    }

    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('post_type', $type);
    }

    // ── Slug ────────────────────────────────────────────────────
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title_it')
            ->saveSlugsTo('slug');
    }

    // ── Scopes ──────────────────────────────────────────────────
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // ── Accessors localizzati ────────────────────────────────────
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

    // ── Accessors SEO ────────────────────────────────────────────

    /** Titolo per <title> tag — usa seo_title se impostato, altrimenti il titolo normale */
    public function getMetaTitleAttribute(): string
    {
        $locale = app()->getLocale();
        $seo = $locale === 'it' ? $this->seo_title_it : $this->seo_title_en;
        return $seo ?: $this->getTitleAttribute();
    }

    /** Descrizione per <meta name="description"> */
    public function getMetaDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        $seo = $locale === 'it' ? $this->seo_description_it : $this->seo_description_en;
        return $seo ?: $this->getExcerptAttribute();
    }

    /** Immagine OG — usa og_image se impostata, altrimenti image_url */
    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ?: $this->image_url;
    }

    /** Calcola automaticamente il tempo di lettura dal body (200 parole/min) */
    public function getComputedReadingTimeAttribute(): int
    {
        if ($this->reading_time) {
            return $this->reading_time;
        }
        $body = strip_tags($this->body_it ?? '');
        $words = str_word_count($body);
        return max(1, (int) ceil($words / 200));
    }

    // ── Label categoria ──────────────────────────────────────────
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'natura'      => '🌿 Natura',
            'storia'      => '🏛️ Storia',
            'gastronomia' => '🍝 Gastronomia',
            'mare'        => '🏖️ Mare',
            'borghi'      => '🏘️ Borghi',
            'eventi'      => '🎭 Eventi',
            'cultura'     => '🏛️ Cultura',
            'citta'       => '🏙️ Città',
            default       => ucfirst($this->category ?? ''),
        };
    }
}
