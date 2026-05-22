<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $navigationIcon  = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?string $navigationGroup = 'Contenuti';
    protected static ?int    $navigationSort  = 13;
    protected static ?string $modelLabel      = 'FAQ';
    protected static ?string $pluralModelLabel = 'FAQ';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('category')
                    ->label('Categoria')
                    ->options(Faq::categories())
                    ->required()
                    ->default('generale'),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Ordine')
                    ->numeric()
                    ->default(0),
            ]),

            Forms\Components\Tabs::make('Contenuto multilingua')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('🇮🇹 Italiano')
                        ->schema([
                            Forms\Components\TextInput::make('question_it')
                                ->label('Domanda (IT)')
                                ->required()
                                ->maxLength(300),
                            Forms\Components\Textarea::make('answer_it')
                                ->label('Risposta (IT)')
                                ->required()
                                ->rows(4),
                        ]),

                    Forms\Components\Tabs\Tab::make('🇬🇧 English')
                        ->schema([
                            Forms\Components\TextInput::make('question_en')
                                ->label('Question (EN)')
                                ->maxLength(300),
                            Forms\Components\Textarea::make('answer_en')
                                ->label('Answer (EN)')
                                ->rows(4),
                        ]),

                    Forms\Components\Tabs\Tab::make('🇩🇪 Deutsch')
                        ->schema([
                            Forms\Components\TextInput::make('question_de')
                                ->label('Frage (DE)')
                                ->maxLength(300),
                            Forms\Components\Textarea::make('answer_de')
                                ->label('Antwort (DE)')
                                ->rows(4),
                        ]),

                    Forms\Components\Tabs\Tab::make('🇫🇷 Français')
                        ->schema([
                            Forms\Components\TextInput::make('question_fr')
                                ->label('Question (FR)')
                                ->maxLength(300),
                            Forms\Components\Textarea::make('answer_fr')
                                ->label('Réponse (FR)')
                                ->rows(4),
                        ]),
                ])
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
                ->label('Attiva')
                ->default(true)
                ->onColor('success'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Faq::categories()[$state] ?? $state)
                    ->color('info'),

                Tables\Columns\TextColumn::make('question_it')
                    ->label('Domanda')
                    ->searchable()
                    ->limit(60)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('answer_it')
                    ->label('Risposta')
                    ->limit(50)
                    ->color('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attiva')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options(Faq::categories()),
                Tables\Filters\TernaryFilter::make('is_active')->label('Attiva'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
