<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'category',
        'question_it', 'question_en', 'question_de', 'question_fr',
        'answer_it', 'answer_en', 'answer_de', 'answer_fr',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getQuestion(string $locale = 'it'): string
    {
        return $this->{"question_{$locale}"} ?? $this->question_it ?? '';
    }

    public function getAnswer(string $locale = 'it'): string
    {
        return $this->{"answer_{$locale}"} ?? $this->answer_it ?? '';
    }

    public static function categories(): array
    {
        return [
            'generale' => '📋 Generale',
            'voli'     => '✈️ Voli',
            'turismo'  => '🏖️ Turismo',
            'servizi'  => '🛎️ Servizi aeroporto',
            'trasporti'=> '🚌 Trasporti',
        ];
    }
}
