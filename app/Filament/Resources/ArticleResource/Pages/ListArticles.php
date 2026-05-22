<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\TourismArticle as Article;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuovo articolo')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tutti')
                ->icon('heroicon-o-list-bullet')
                ->badge(Article::count()),

            'tourism' => Tab::make('🏖️ Turismo')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('post_type', 'tourism'))
                ->badge(Article::where('post_type', 'tourism')->count()),

            'news' => Tab::make('📰 Notizie')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('post_type', 'news'))
                ->badge(Article::where('post_type', 'news')->count()),

            'city' => Tab::make('🏙️ Città')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('post_type', 'city'))
                ->badge(Article::where('post_type', 'city')->count()),

            'guide' => Tab::make('📖 Guide')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('post_type', 'guide'))
                ->badge(Article::where('post_type', 'guide')->count()),

            'published' => Tab::make('Pubblicati')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('is_published', true)),

            'drafts' => Tab::make('Bozze')
                ->icon('heroicon-o-pencil')
                ->modifyQueryUsing(fn (Builder $q) => $q->where('is_published', false)),
        ];
    }
}
