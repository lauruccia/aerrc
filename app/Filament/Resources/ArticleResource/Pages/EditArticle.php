<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Anteprima')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(fn () => route('tourism.show', $this->getRecord()->slug))
                ->openUrlInNewTab(),

            Actions\Action::make('togglePublish')
                ->label(fn () => $this->getRecord()->is_published ? 'Metti in bozza' : 'Pubblica ora')
                ->icon(fn () => $this->getRecord()->is_published ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                ->color(fn () => $this->getRecord()->is_published ? 'warning' : 'success')
                ->action(function () {
                    $r = $this->getRecord();
                    $r->update([
                        'is_published' => !$r->is_published,
                        'published_at' => !$r->is_published ? now() : $r->published_at,
                    ]);
                    $this->refreshFormData(['is_published', 'published_at']);
                }),

            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['reading_time']) && !empty($data['body_it'])) {
            $words = str_word_count(strip_tags($data['body_it']));
            $data['reading_time'] = max(1, (int) ceil($words / 200));
        }
        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Articolo salvato';
    }
}
