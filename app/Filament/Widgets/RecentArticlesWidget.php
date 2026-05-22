<?php

namespace App\Filament\Widgets;

use App\Models\TourismArticle as Article;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentArticlesWidget extends BaseWidget
{
    protected static ?int $sort       = 2;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Ultimi articoli modificati';

    public function table(Table $table): Table
    {
        return $table
            ->query(Article::query()->orderByDesc('updated_at')->limit(8))
            ->columns([
                Tables\Columns\TextColumn::make('post_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Article::postTypes()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        'tourism' => 'info', 'news' => 'danger',
                        'city' => 'success', 'guide' => 'warning', default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('title_it')
                    ->label('Titolo')
                    ->limit(50),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean()->trueColor('success')->falseColor('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modificato')
                    ->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Modifica')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Article $r) => route('filament.admin.resources.articles.edit', $r)),
            ]);
    }
}
