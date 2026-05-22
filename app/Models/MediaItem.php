<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaItem extends Model
{
    protected $fillable = [
        'filename', 'original_name', 'mime_type', 'size',
        'category', 'title', 'alt_text', 'caption',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'size'      => 'integer',
    ];

    public function getUrlAttribute(): string
    {
        return Storage::url('media/' . $this->filename);
    }

    public function getSizeForHumansAttribute(): string
    {
        $bytes = $this->size;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    public static function categories(): array
    {
        return [
            'generale'     => '📁 Generale',
            'hero'         => '🖼️ Hero / Banner',
            'destinazioni' => '✈️ Destinazioni',
            'turismo'      => '🏖️ Turismo & Guide',
            'partner'      => '🤝 Partner & Loghi',
            'news'         => '📰 News',
        ];
    }
}
