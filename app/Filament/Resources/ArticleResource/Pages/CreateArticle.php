<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['reading_time']) && !empty($data['body_it'])) {
            $words = str_word_count(strip_tags($data['body_it']));
            $data['reading_time'] = max(1, (int) ceil($words / 200));
        }
        return $data;
    }
}
