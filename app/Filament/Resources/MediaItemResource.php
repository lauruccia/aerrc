<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaItemResource\Pages;
use App\Models\MediaItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MediaItemResource extends Resource
{
    protected static ?string $model = MediaItem::class;
    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Media & Immagini';
    protected static ?string $navigationGroup = 'Contenuti';
    protected static ?int    $navigationSort  = 12;
    protected static ?string $modelLabel      = 'Media';
    protected static ?string $pluralModelLabel = 'Media';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('File')
                ->schema([
                    Forms\Components\FileUpload::make('filename')
                        ->label('File immagine')
                        ->image()
                        ->imagePreviewHeight('200')
                        ->directory('media')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'])
                        ->maxSize(5120)
                        ->required()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state) {
                                $set('original_name', $state);
                                $set('mime_type', 'image/jpeg');
                            }
                        })
                        ->columnSpanFull(),

                    Forms\Components\Hidden::make('original_name'),
                    Forms\Components\Hidden::make('mime_type'),
                    Forms\Components\Hidden::make('size')->default(0),
                ]),

            Forms\Components\Section::make('Metadati')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('category')
                        ->label('Categoria')
                        ->options(MediaItem::categories())
                        ->required()
                        ->default('generale'),

                    Forms\Components\TextInput::make('sort_order')
                        ->label('Ordine')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('title')
                        ->label('Titolo')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('alt_text')
                        ->label('Alt text (SEO accessibilità)')
                        ->maxLength(255)
                        ->helperText('Descrizione breve per screen reader e SEO')
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('caption')
                        ->label('Didascalia')
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Attivo')
                        ->default(true)
                        ->onColor('success'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('filename')
                    ->label('Anteprima')
                    ->disk('public')
                    ->getStateUsing(fn ($record) => 'media/' . $record->filename)
                    ->height(60)
                    ->width(80)
                    ->extraImgAttributes(['style' => 'object-fit:cover;border-radius:6px']),

                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable()
                    ->default(fn ($record) => $record->original_name ?? $record->filename)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->formatStateUsing(fn ($state) => MediaItem::categories()[$state] ?? $state)
                    ->color('info'),

                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt text')
                    ->limit(40)
                    ->color('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Caricato')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options(MediaItem::categories()),
                Tables\Filters\TernaryFilter::make('is_active')->label('Attivo'),
            ])
            ->actions([
                Tables\Actions\Action::make('copy_url')
                    ->label('Copia URL')
                    ->icon('heroicon-o-clipboard')
                    ->color('gray')
                    ->action(fn () => null)
                    ->extraAttributes(fn ($record) => [
                        'x-on:click' => "navigator.clipboard.writeText('" . Storage::url('media/' . $record->filename) . "'); \$dispatch('notify', {message: 'URL copiato!'})",
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(fn ($record) => Storage::disk('public')->delete('media/' . $record->filename)),
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
            'index'  => Pages\ListMediaItems::route('/'),
            'create' => Pages\CreateMediaItem::route('/create'),
            'edit'   => Pages\EditMediaItem::route('/{record}/edit'),
        ];
    }
}
