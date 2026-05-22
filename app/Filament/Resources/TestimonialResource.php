<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon  = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Recensioni';
    protected static ?string $navigationGroup = 'Contenuti';
    protected static ?int    $navigationSort  = 14;
    protected static ?string $modelLabel      = 'Recensione';
    protected static ?string $pluralModelLabel = 'Recensioni';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Autore')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('author_name')
                        ->label('Nome autore')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('author_role')
                        ->label('Ruolo / provenienza')
                        ->placeholder('Turista da Milano')
                        ->maxLength(100),

                    Forms\Components\Select::make('source')
                        ->label('Fonte')
                        ->options(Testimonial::sources())
                        ->default('sito'),

                    Forms\Components\Select::make('stars')
                        ->label('Stelle')
                        ->options([5 => '⭐⭐⭐⭐⭐', 4 => '⭐⭐⭐⭐', 3 => '⭐⭐⭐', 2 => '⭐⭐', 1 => '⭐'])
                        ->default(5),

                    Forms\Components\TextInput::make('sort_order')
                        ->label('Ordine')
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Attiva')
                        ->default(true)
                        ->onColor('success'),
                ]),

            Forms\Components\Tabs::make('Testo recensione')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('🇮🇹 Italiano')
                        ->schema([
                            Forms\Components\Textarea::make('text_it')
                                ->label('Testo (IT)')
                                ->required()
                                ->rows(4),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇬🇧 English')
                        ->schema([
                            Forms\Components\Textarea::make('text_en')
                                ->label('Text (EN)')
                                ->rows(4),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇩🇪 Deutsch')
                        ->schema([
                            Forms\Components\Textarea::make('text_de')
                                ->label('Text (DE)')
                                ->rows(4),
                        ]),
                    Forms\Components\Tabs\Tab::make('🇫🇷 Français')
                        ->schema([
                            Forms\Components\Textarea::make('text_fr')
                                ->label('Texte (FR)')
                                ->rows(4),
                        ]),
                ])
                ->columnSpanFull(),
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

                Tables\Columns\TextColumn::make('stars')
                    ->label('⭐')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Autore')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('author_role')
                    ->label('Ruolo')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('text_it')
                    ->label('Testo')
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\TextColumn::make('source')
                    ->label('Fonte')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Testimonial::sources()[$state] ?? $state)
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attiva')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Attiva'),
                Tables\Filters\SelectFilter::make('source')
                    ->label('Fonte')
                    ->options(Testimonial::sources()),
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
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
