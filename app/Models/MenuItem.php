<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = [
        'position', 'label_it', 'label_en', 'label_de', 'label_fr',
        'url', 'target', 'icon', 'parent_id', 'sort_order',
        'is_active', 'is_highlight',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_highlight' => 'boolean',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function getLabel(string $locale = 'it'): string
    {
        return $this->{"label_{$locale}"} ?? $this->label_it ?? '';
    }

    public static function forPosition(string $position, string $locale = 'it')
    {
        return static::where('position', $position)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->get();
    }
}
