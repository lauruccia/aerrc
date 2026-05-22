<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];

    // ── Lettura ──────────────────────────────────────────────────

    /**
     * Legge un'impostazione per chiave, con valore di default opzionale.
     * Usa cache per 1 ora.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = static::allCached();
        return $settings[$key] ?? $default;
    }

    /**
     * Legge tutte le impostazioni di un gruppo.
     */
    public static function group(string $group): array
    {
        $settings = static::allCached();
        return array_filter($settings, fn ($v, $k) => str_starts_with($k, $group . '_') || static::query()->where('key', $k)->value('group') === $group, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Cache di tutte le impostazioni come array chiave => valore.
     */
    public static function allCached(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            return static::query()->pluck('value', 'key')->toArray();
        });
    }

    // ── Scrittura ────────────────────────────────────────────────

    /**
     * Aggiorna (o crea) un'impostazione e invalida la cache.
     */
    public static function set(string $key, mixed $value): void
    {
        static::query()->updateOrInsert(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    /**
     * Aggiorna in blocco un array di impostazioni.
     */
    public static function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            static::query()->where('key', $key)->update(['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
