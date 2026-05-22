<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Pagine Statiche';
    protected static ?string $navigationGroup = 'Contenuti';
    protected static ?int    $navigationSort  = 10;
    protected static ?string $modelLabel      = 'Pagina';
    protected static ?string $pluralModelLabel = 'Pagine';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Pagina')
                ->tabs([

                    Forms\Components\Tabs\Tab::make('🇮🇹 Italiano')
                        ->schema([
                            Forms\Components\TextInput::make('title_it')
                                ->label('Titolo (IT)')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('content_it')
                                ->label('Contenuto (IT)')
                                ->toolbarButtons([
                                    'bold','italic','underline','strike',
                                    'h2','h3','bulletList','orderedList',
                                    'link','blockquote','undo','redo',
                                ])
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('🇬🇧 English')
                        ->schema([
                            Forms\Components\TextInput::make('title_en')
                                ->label('Title (EN)')
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('content_en')
                                ->label('Content (EN)')
                                ->toolbarButtons([
                                    'bold','italic','underline','strike',
                                    'h2','h3','bulletList','orderedList',
                                    'link','blockquote','undo','redo',
                                ])
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('🇩🇪 Deutsch')
                        ->schema([
                            Forms\Components\TextInput::make('title_de')
                                ->label('Titel (DE)')
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('content_de')
                                ->label('Inhalt (DE)')
                                ->toolbarButtons([
                                    'bold','italic','underline','strike',
                                    'h2','h3','bulletList','orderedList',
                                    'link','blockquote','undo','redo',
                                ])
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('🇫🇷 Français')
                        ->schema([
                            Forms\Components\TextInput::make('title_fr')
                                ->label('Titre (FR)')
                                ->maxLength(255),
                            Forms\Components\RichEditor::make('content_fr')
                                ->label('Contenu (FR)')
                                ->toolbarButtons([
                                    'bold','italic','underline','strike',
                                    'h2','h3','bulletList','orderedList',
                                    'link','blockquote','undo','redo',
                                ])
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Tabs\Tab::make('⚙️ Impostazioni & SEO')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Es: chi-siamo, privacy-policy')
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Ordine')
                                    ->numeric()
                                    ->default(0),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Pagina attiva')
                                    ->default(true)
                                    ->onColor('success'),

                                Forms\Components\Toggle::make('show_in_footer')
                                    ->label('Mostra nel footer')
                                    ->default(false)
                                    ->onColor('info'),
                            ]),

                            Forms\Components\Section::make('SEO')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('meta_title_it')
                                            ->label('Meta Title (IT)')
                                            ->maxLength(70),
                                        Forms\Components\TextInput::make('meta_title_en')
                                            ->label('Meta Title (EN)')
                                            ->maxLength(70),
                                    ]),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\Textarea::make('meta_desc_it')
                                            ->label('Meta Description (IT)')
                                            ->rows(2)
                                            ->maxLength(165),
                                        Forms\Components\Textarea::make('meta_desc_en')
                                            ->label('Meta Description (EN)')
                                            ->rows(2)
                                            ->maxLength(165),
                                    ]),
                                ]),
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

                Tables\Columns\TextColumn::make('title_it')
                    ->label('Titolo')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->badge()
                    ->color('gray')
                    ->copyable(),

                Tables\Columns\IconColumn::make('show_in_footer')
                    ->label('Footer')
                    ->boolean()
                    ->trueColor('info')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attiva')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Aggiornata')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Attiva'),
                Tables\Filters\TernaryFilter::make('show_in_footer')->label('Nel footer'),
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
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
