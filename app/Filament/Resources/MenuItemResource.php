<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;
    protected static ?string $navigationIcon  = 'heroicon-o-bars-3';
    protected static ?string $navigationLabel = 'Menu Navigazione';
    protected static ?string $navigationGroup = 'Contenuti';
    protected static ?int    $navigationSort  = 11;
    protected static ?string $modelLabel      = 'Voce menu';
    protected static ?string $pluralModelLabel = 'Voci menu';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Posizione & Struttura')
                ->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Select::make('position')
                            ->label('Posizione')
                            ->options([
                                'header' => '🔝 Header (navigazione principale)',
                                'footer' => '🔻 Footer',
                                'both'   => '↕️ Header + Footer',
                            ])
                            ->required()
                            ->default('header'),

                        Forms\Components\Select::make('parent_id')
                            ->label('Voce padre (sottomenu)')
                            ->options(MenuItem::whereNull('parent_id')->pluck('label_it', 'id'))
                            ->placeholder('— Nessun padre (radice) —')
                            ->nullable(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Ordine')
                            ->numeric()
                            ->default(0),
                    ]),
                ]),

            Forms\Components\Section::make('Etichette multilingua')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('label_it')->label('🇮🇹 Etichetta IT')->required(),
                    Forms\Components\TextInput::make('label_en')->label('🇬🇧 Label EN'),
                    Forms\Components\TextInput::make('label_de')->label('🇩🇪 Bezeichnung DE'),
                    Forms\Components\TextInput::make('label_fr')->label('🇫🇷 Étiquette FR'),
                ]),

            Forms\Components\Section::make('Link & Stile')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('url')
                        ->label('URL / percorso')
                        ->placeholder('/turismo oppure https://...')
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\Select::make('target')
                        ->label('Apertura link')
                        ->options([
                            '_self'  => 'Stessa scheda',
                            '_blank' => 'Nuova scheda',
                        ])
                        ->default('_self'),

                    Forms\Components\TextInput::make('icon')
                        ->label('Icona Heroicon')
                        ->placeholder('heroicon-o-home')
                        ->helperText('Opzionale — nome icona Heroicon outline/solid')
                        ->prefixIcon('heroicon-o-sparkles'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Attiva')
                            ->default(true)
                            ->onColor('success'),

                        Forms\Components\Toggle::make('is_highlight')
                            ->label('Evidenziata (colore accent)')
                            ->default(false)
                            ->onColor('warning'),
                    ]),
                ]),
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

                Tables\Columns\TextColumn::make('position')
                    ->label('Posizione')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'header' => 'info',
                        'footer' => 'gray',
                        'both'   => 'success',
                        default  => 'gray',
                    }),

                Tables\Columns\TextColumn::make('label_it')
                    ->label('Etichetta IT')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(40)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('parent.label_it')
                    ->label('Sotto a')
                    ->placeholder('— radice —')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\IconColumn::make('is_highlight')
                    ->label('✨')
                    ->boolean()
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attiva')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->label('Posizione')
                    ->options([
                        'header' => 'Header',
                        'footer' => 'Footer',
                        'both'   => 'Header + Footer',
                    ]),
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
            'index'  => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit'   => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
