<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinationResource\Pages;
use App\Models\Destination;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    protected static ?string $navigationIcon  = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Destinazioni';
    protected static ?string $navigationGroup = 'Aeroporto';
    protected static ?int    $navigationSort  = 2;

    protected static ?string $modelLabel       = 'Destinazione';
    protected static ?string $pluralModelLabel = 'Destinazioni';

    protected static ?string $recordTitleAttribute = 'city';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([

                // ── Principale ──────────────────────────────────────
                Forms\Components\Group::make()->columnSpan(2)->schema([

                    Forms\Components\Section::make('Informazioni destinazione')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('city')
                                    ->label('Città')
                                    ->required()->maxLength(100)
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('iata_code')
                                    ->label('IATA')
                                    ->maxLength(3)
                                    ->placeholder('ex. FCO')
                                    ->helperText('Codice aeroporto')
                                    ->extraInputAttributes(['style' => 'text-transform:uppercase']),
                            ]),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('country')
                                    ->label('Paese')
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('flag_emoji')
                                    ->label('Bandiera emoji')
                                    ->maxLength(10)
                                    ->placeholder('🇮🇹'),

                                Forms\Components\TextInput::make('price_from')
                                    ->label('Prezzo da (€)')
                                    ->numeric()
                                    ->prefix('€')
                                    ->minValue(0),
                            ]),

                            Forms\Components\TextInput::make('airlines_string')
                                ->label('Compagnie aeree')
                                ->maxLength(255)
                                ->placeholder('Ryanair, easyJet')
                                ->helperText('Separare con virgola')
                                ->columnSpanFull(),
                        ]),

                    // Descrizioni multilingua
                    Forms\Components\Tabs::make('Descrizione')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('🇮🇹 Italiano')
                                ->schema([
                                    Forms\Components\Textarea::make('description_it')
                                        ->label('Descrizione (IT)')
                                        ->rows(5)->maxLength(1000)->columnSpanFull(),
                                ]),
                            Forms\Components\Tabs\Tab::make('🇬🇧 English')
                                ->schema([
                                    Forms\Components\Textarea::make('description_en')
                                        ->label('Description (EN)')
                                        ->rows(5)->maxLength(1000)->columnSpanFull(),
                                ]),
                            Forms\Components\Tabs\Tab::make('🇩🇪 Deutsch')
                                ->schema([
                                    Forms\Components\Textarea::make('description_de')
                                        ->label('Beschreibung (DE)')
                                        ->rows(5)->maxLength(1000)->columnSpanFull(),
                                ]),
                            Forms\Components\Tabs\Tab::make('🇫🇷 Français')
                                ->schema([
                                    Forms\Components\Textarea::make('description_fr')
                                        ->label('Description (FR)')
                                        ->rows(5)->maxLength(1000)->columnSpanFull(),
                                ]),
                        ]),
                ]),

                // ── Sidebar ──────────────────────────────────────────
                Forms\Components\Group::make()->columnSpan(1)->schema([

                    Forms\Components\Section::make('Stato')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Attiva')
                                ->onColor('success')
                                ->default(true),

                            Forms\Components\TextInput::make('sort_order')
                                ->label('Ordine visualizzazione')
                                ->numeric()->default(0)
                                ->helperText('Numero più basso = prima posizione'),
                        ]),

                    Forms\Components\Section::make('🎨 Aspetto')
                        ->schema([
                            Forms\Components\ColorPicker::make('color_from')
                                ->label('Colore (inizio)')
                                ->default('#1A5276'),
                            Forms\Components\ColorPicker::make('color_to')
                                ->label('Colore (fine)')
                                ->default('#2E86C1'),
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flag_emoji')
                    ->label('')
                    ->width(40),

                Tables\Columns\TextColumn::make('city')
                    ->label('Città')
                    ->searchable()->sortable()
                    ->description(fn (Destination $r) => $r->country),

                Tables\Columns\TextColumn::make('iata_code')
                    ->label('IATA')
                    ->badge()->color('gray'),

                Tables\Columns\TextColumn::make('airlines_string')
                    ->label('Compagnie')
                    ->limit(40)
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('price_from')
                    ->label('Da')
                    ->money('EUR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attiva')
                    ->boolean()
                    ->trueColor('success')->falseColor('gray'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ord.')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Stato')
                    ->trueLabel('Solo attive')
                    ->falseLabel('Solo disattive'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Attiva')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit'   => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
