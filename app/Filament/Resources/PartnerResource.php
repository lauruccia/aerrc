<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon  = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Partner & Sponsor';
    protected static ?string $navigationGroup = 'Commerciale';
    protected static ?int    $navigationSort  = 1;

    protected static ?string $modelLabel       = 'Partner';
    protected static ?string $pluralModelLabel = 'Partner & Sponsor';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)->schema([

                Forms\Components\Group::make()->columnSpan(2)->schema([
                    Forms\Components\Section::make('Informazioni partner')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nome')
                                ->required()->maxLength(255)
                                ->live(debounce: 800)
                                ->afterStateUpdated(fn (Get $get, Set $set, ?string $state) =>
                                    !$get('slug') ? $set('slug', Str::slug($state ?? '')) : null
                                ),

                            Forms\Components\TextInput::make('website_url')
                                ->label('Sito web')
                                ->url()->maxLength(500)
                                ->prefixIcon('heroicon-o-globe-alt'),

                            Forms\Components\TextInput::make('contact_email')
                                ->label('Email contatto')
                                ->email()->maxLength(255)
                                ->prefixIcon('heroicon-o-envelope'),

                            Forms\Components\TextInput::make('logo_url')
                                ->label('URL Logo')
                                ->url()->maxLength(500)
                                ->prefixIcon('heroicon-o-photo')
                                ->helperText('Link diretto all\'immagine del logo (PNG/SVG con sfondo trasparente preferito)')
                                ->columnSpanFull(),

                            // Anteprima logo
                            Forms\Components\Placeholder::make('logo_preview')
                                ->label('Anteprima logo')
                                ->content(function (Get $get): \Illuminate\Support\HtmlString {
                                    $url = $get('logo_url');
                                    if (!$url) return new \Illuminate\Support\HtmlString('<p style="color:#888;font-style:italic">Inserisci un URL logo per vedere l\'anteprima.</p>');
                                    return new \Illuminate\Support\HtmlString(
                                        '<div style="background:#f5f5f5;border-radius:8px;padding:16px;display:inline-block">'
                                        . '<img src="' . e($url) . '" style="max-height:80px;max-width:300px;object-fit:contain" alt="Logo" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'block\'">'
                                        . '<p style="display:none;color:#c0392b;font-size:13px">⚠️ Impossibile caricare l\'immagine</p>'
                                        . '</div>'
                                    );
                                })
                                ->columnSpanFull(),
                        ])->columns(2),

                    Forms\Components\Section::make('Descrizione')
                        ->schema([
                            Forms\Components\Tabs::make('desc')
                                ->tabs([
                                    Forms\Components\Tabs\Tab::make('🇮🇹 Italiano')
                                        ->schema([
                                            Forms\Components\Textarea::make('description_it')
                                                ->label('Descrizione (IT)')
                                                ->rows(4)->maxLength(1000)->columnSpanFull(),
                                        ]),
                                    Forms\Components\Tabs\Tab::make('🇬🇧 English')
                                        ->schema([
                                            Forms\Components\Textarea::make('description_en')
                                                ->label('Description (EN)')
                                                ->rows(4)->maxLength(1000)->columnSpanFull(),
                                        ]),
                                ]),
                        ]),
                ]),

                Forms\Components\Group::make()->columnSpan(1)->schema([
                    Forms\Components\Section::make('Classificazione')
                        ->schema([
                            Forms\Components\Select::make('category')
                                ->label('Categoria')
                                ->required()
                                ->options([
                                    'airline'       => '✈️ Compagnia Aerea',
                                    'hotel'         => '🏨 Hotel / Ricettività',
                                    'tour_operator' => '🗺️ Tour Operator',
                                    'institution'   => '🏛️ Ente Pubblico',
                                    'media'         => '📺 Media Partner',
                                    'service'       => '🔧 Servizi',
                                    'other'         => '🤝 Altro',
                                ])
                                ->default('other')
                                ->native(false),

                            Forms\Components\Select::make('tier')
                                ->label('Livello partnership')
                                ->options([
                                    'gold'     => '🥇 Gold',
                                    'silver'   => '🥈 Silver',
                                    'bronze'   => '🥉 Bronze',
                                    'standard' => '🤝 Standard',
                                ])
                                ->default('standard')
                                ->native(false)
                                ->helperText('Influisce sulla visibilità nella pagina partner'),
                        ]),

                    Forms\Components\Section::make('Visibilità')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Attivo')
                                ->onColor('success')
                                ->default(true),

                            Forms\Components\Toggle::make('is_featured_homepage')
                                ->label('Homepage')
                                ->onColor('warning')
                                ->helperText('Mostra in homepage'),

                            Forms\Components\TextInput::make('sort_order')
                                ->label('Ordine')
                                ->numeric()->default(0),
                        ]),

                    Forms\Components\Section::make('🔗 Slug')
                        ->schema([
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->unique(Partner::class, 'slug', ignoreRecord: true)
                                ->maxLength(255),
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->height(32)
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=P&color=0D2B4B&background=C9A84C')
                    ->circular(false),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()->sortable()
                    ->description(fn (Partner $r) => $r->website_url),

                Tables\Columns\TextColumn::make('category')
                    ->label('Categoria')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'airline'       => '✈️ Airline',
                        'hotel'         => '🏨 Hotel',
                        'tour_operator' => '🗺️ Tour Op.',
                        'institution'   => '🏛️ Ente',
                        'media'         => '📺 Media',
                        'service'       => '🔧 Servizi',
                        default         => '🤝 Altro',
                    })
                    ->color('gray'),

                Tables\Columns\TextColumn::make('tier')
                    ->label('Tier')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'gold'   => '🥇 Gold',
                        'silver' => '🥈 Silver',
                        'bronze' => '🥉 Bronze',
                        default  => '🤝 Std',
                    })
                    ->color(fn ($state) => match($state) {
                        'gold'   => 'warning',
                        'silver' => 'gray',
                        'bronze' => 'danger',
                        default  => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean()->trueColor('success')->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_featured_homepage')
                    ->label('Home')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->trueColor('warning')->falseColor('gray'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ord.')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'airline'       => 'Compagnia Aerea',
                        'hotel'         => 'Hotel',
                        'tour_operator' => 'Tour Operator',
                        'institution'   => 'Ente Pubblico',
                        'media'         => 'Media',
                        'service'       => 'Servizi',
                    ]),
                Tables\Filters\SelectFilter::make('tier')
                    ->options(['gold' => 'Gold', 'silver' => 'Silver', 'bronze' => 'Bronze', 'standard' => 'Standard']),
                Tables\Filters\TernaryFilter::make('is_active')->label('Stato'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Attiva')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit'   => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
