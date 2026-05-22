<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\TourismArticle as Article;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Articoli';
    protected static ?string $navigationGroup = 'Contenuti';
    protected static ?int    $navigationSort  = 1;

    protected static ?string $modelLabel       = 'Articolo';
    protected static ?string $pluralModelLabel = 'Articoli';

    protected static ?string $recordTitleAttribute = 'title_it';

    // ═══════════════════════════════════════════════════════════════
    // FORM
    // ═══════════════════════════════════════════════════════════════

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Grid::make(3)->schema([

                // ── Colonna principale (2/3) ──────────────────────────
                Forms\Components\Group::make()->columnSpan(2)->schema([

                    // ─ Tipo articolo (sempre visibile in cima) ────────
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('post_type')
                            ->label('Tipo di contenuto')
                            ->required()
                            ->options(Article::postTypes())
                            ->default('tourism')
                            ->native(false)
                            ->live()
                            ->columnSpanFull(),
                    ])->columns(1),

                    // ─ Tab contenuto multilingua ──────────────────────
                    Forms\Components\Tabs::make('Contenuto')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('🇮🇹  Italiano')
                                ->schema(static::contentFields('it')),
                            Forms\Components\Tabs\Tab::make('🇬🇧  English')
                                ->schema(static::contentFields('en')),
                            Forms\Components\Tabs\Tab::make('🇩🇪  Deutsch')
                                ->schema(static::contentFields('de')),
                            Forms\Components\Tabs\Tab::make('🇫🇷  Français')
                                ->schema(static::contentFields('fr')),
                        ])
                        ->columnSpanFull(),

                    // ─ SEO ───────────────────────────────────────────
                    Forms\Components\Section::make('🔍 SEO')
                        ->description('Ottimizza come questo articolo appare nei motori di ricerca')
                        ->collapsible()
                        ->schema([

                            // Anteprima Google
                            Forms\Components\Placeholder::make('seo_preview')
                                ->label('Anteprima Google')
                                ->content(function (Get $get): \Illuminate\Support\HtmlString {
                                    $title = $get('seo_title_it') ?: $get('title_it') ?: 'Titolo articolo';
                                    $desc  = $get('seo_description_it') ?: $get('excerpt_it') ?: 'Descrizione...';
                                    $slug  = $get('slug') ?: 'url-articolo';
                                    $titleLen = mb_strlen($title);
                                    $descLen  = mb_strlen($desc);
                                    $tCol = $titleLen > 60 ? '#c0392b' : '#1a0dab';
                                    $dCol = $descLen  > 160 ? '#c0392b' : '#4d5156';
                                    return new \Illuminate\Support\HtmlString(
                                        '<div style="font-family:arial,sans-serif;border:1px solid #ddd;border-radius:8px;padding:16px;background:#fff;max-width:600px">'
                                        . '<div style="font-size:12px;color:#006621;margin-bottom:2px">aeroportoreggiocalabria.it › ' . e($slug) . '</div>'
                                        . '<div style="font-size:20px;color:' . $tCol . ';line-height:1.3;margin-bottom:4px">' . e($title) . '</div>'
                                        . '<div style="font-size:13px;color:' . $dCol . ';line-height:1.5">' . e(Str::limit($desc, 200)) . '</div>'
                                        . '<div style="margin-top:8px;font-size:11px;color:#999">'
                                        . 'Titolo: <b style="color:' . $tCol . '">' . $titleLen . '/60</b> &nbsp;|&nbsp; '
                                        . 'Desc: <b style="color:' . $dCol . '">' . $descLen . '/160</b> caratteri'
                                        . '</div></div>'
                                    );
                                })
                                ->columnSpanFull(),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('seo_title_it')
                                    ->label('SEO Title (IT)')
                                    ->placeholder('Lascia vuoto per usare il titolo')
                                    ->maxLength(70)
                                    ->live(debounce: 500)
                                    ->helperText(fn (Get $get) => self::charCounter($get('seo_title_it'), 60)),

                                Forms\Components\TextInput::make('seo_title_en')
                                    ->label('SEO Title (EN)')
                                    ->maxLength(70)
                                    ->helperText(fn (Get $get) => self::charCounter($get('seo_title_en'), 60)),

                                Forms\Components\Textarea::make('seo_description_it')
                                    ->label('Meta Description (IT)')
                                    ->placeholder('Lascia vuoto per usare l\'excerpt')
                                    ->maxLength(165)->rows(3)
                                    ->live(debounce: 500)
                                    ->helperText(fn (Get $get) => self::charCounter($get('seo_description_it'), 160)),

                                Forms\Components\Textarea::make('seo_description_en')
                                    ->label('Meta Description (EN)')
                                    ->maxLength(165)->rows(3)
                                    ->helperText(fn (Get $get) => self::charCounter($get('seo_description_en'), 160)),
                            ]),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('focus_keyword')
                                    ->label('Focus Keyword')
                                    ->placeholder('es. spiagge calabria')
                                    ->maxLength(100)
                                    ->prefixIcon('heroicon-o-magnifying-glass'),

                                Forms\Components\TextInput::make('og_image')
                                    ->label('OG Image URL')
                                    ->url()->maxLength(500)
                                    ->prefixIcon('heroicon-o-photo'),

                                Forms\Components\TextInput::make('canonical_url')
                                    ->label('Canonical URL')
                                    ->url()->maxLength(500)
                                    ->prefixIcon('heroicon-o-link'),
                            ]),

                            // Analisi SEO
                            Forms\Components\Placeholder::make('seo_analysis')
                                ->label('Analisi SEO')
                                ->content(function (Get $get): \Illuminate\Support\HtmlString {
                                    $keyword = strtolower(trim($get('focus_keyword') ?? ''));
                                    if (empty($keyword)) {
                                        return new \Illuminate\Support\HtmlString('<p style="color:#888;font-style:italic">Inserisci una focus keyword per l\'analisi SEO.</p>');
                                    }
                                    $checks = [
                                        'Keyword nel titolo'     => str_contains(strtolower($get('title_it') ?? ''), $keyword),
                                        'Keyword nell\'excerpt'  => str_contains(strtolower($get('excerpt_it') ?? ''), $keyword),
                                        'Keyword nel body'       => str_contains(strtolower(strip_tags($get('body_it') ?? '')), $keyword),
                                        'Keyword nello slug'     => str_contains(strtolower($get('slug') ?? ''), $keyword),
                                        'Titolo compilato'       => !empty(trim($get('title_it') ?? '')),
                                        'Excerpt compilato'      => !empty(trim($get('excerpt_it') ?? '')),
                                        'Body compilato'         => !empty(trim(strip_tags($get('body_it') ?? ''))),
                                        'Immagine presente'      => !empty($get('image_url')),
                                    ];
                                    $html = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;max-width:600px">';
                                    foreach ($checks as $label => $pass) {
                                        $icon = $pass ? '✅' : '❌';
                                        $col  = $pass ? '#27ae60' : '#c0392b';
                                        $html .= "<div style='font-size:13px;color:{$col}'>{$icon} {$label}</div>";
                                    }
                                    $html .= '</div>';
                                    return new \Illuminate\Support\HtmlString($html);
                                })
                                ->columnSpanFull(),
                        ]),
                ]),

                // ── Sidebar (1/3) ─────────────────────────────────────
                Forms\Components\Group::make()->columnSpan(1)->schema([

                    // Pubblicazione
                    Forms\Components\Section::make('📢 Pubblicazione')
                        ->schema([
                            Forms\Components\Toggle::make('is_published')
                                ->label('Pubblicato')
                                ->onColor('success'),

                            Forms\Components\Toggle::make('is_featured')
                                ->label('In evidenza')
                                ->onColor('warning'),

                            Forms\Components\Toggle::make('is_breaking')
                                ->label('🔴 Breaking News')
                                ->onColor('danger')
                                ->visible(fn (Get $get) => $get('post_type') === 'news'),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Data pubblicazione')
                                ->native(false)
                                ->displayFormat('d/m/Y H:i')
                                ->default(now()),

                            Forms\Components\TextInput::make('author')
                                ->label('Autore')
                                ->maxLength(100)
                                ->prefixIcon('heroicon-o-user'),

                            Forms\Components\TextInput::make('source')
                                ->label('Fonte')
                                ->maxLength(200)
                                ->placeholder('es. ANSA, Comune di RC')
                                ->prefixIcon('heroicon-o-newspaper')
                                ->visible(fn (Get $get) => $get('post_type') === 'news')
                                ->helperText('Fonte della notizia'),

                            Forms\Components\TextInput::make('reading_time')
                                ->label('Lettura (min)')
                                ->numeric()->minValue(1)->maxValue(60)
                                ->placeholder('Auto')
                                ->prefixIcon('heroicon-o-clock'),
                        ]),

                    // URL
                    Forms\Components\Section::make('🔗 URL')
                        ->schema([
                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()->maxLength(255)
                                ->unique(Article::class, 'slug', ignoreRecord: true)
                                ->prefixIcon('heroicon-o-link')
                                ->helperText('aeroportoreggiocalabria.it/…/{slug}')
                                ->suffixAction(
                                    Action::make('regen')
                                        ->icon('heroicon-m-arrow-path')
                                        ->tooltip('Rigenera da titolo')
                                        ->action(fn (Get $get, Set $set) => $set('slug', Str::slug($get('title_it'))))
                                ),
                        ]),

                    // Categoria & aspetto
                    Forms\Components\Section::make('🎨 Categoria & Aspetto')
                        ->schema([
                            Forms\Components\Select::make('category')
                                ->label('Categoria')
                                ->required()
                                ->options(fn (Get $get) => self::categoriesFor($get('post_type') ?? 'tourism'))
                                ->native(false)
                                ->searchable(),

                            Forms\Components\TextInput::make('image_url')
                                ->label('Immagine (URL)')
                                ->url()->maxLength(500)
                                ->prefixIcon('heroicon-o-photo'),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\ColorPicker::make('color_from')
                                    ->label('Colore (inizio)')
                                    ->default('#0D2B4B'),
                                Forms\Components\ColorPicker::make('color_to')
                                    ->label('Colore (fine)')
                                    ->default('#1A5276'),
                            ]),
                        ]),

                    // Robots
                    Forms\Components\Section::make('🤖 Indicizzazione')
                        ->collapsible()->collapsed()
                        ->schema([
                            Forms\Components\Select::make('robots')
                                ->label('Robots')
                                ->options([
                                    'index'            => '✅ index, follow',
                                    'noindex'          => '🚫 noindex, follow',
                                    'noindex_nofollow' => '🚫 noindex, nofollow',
                                ])
                                ->default('index')
                                ->native(false),
                        ]),
                ]),

            ]),
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    // TABLE
    // ═══════════════════════════════════════════════════════════════

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post_type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Article::postTypes()[$state] ?? $state)
                    ->color(fn ($state) => match($state) {
                        'tourism' => 'info',
                        'news'    => 'danger',
                        'city'    => 'success',
                        'guide'   => 'warning',
                        default   => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_it')
                    ->label('Titolo')
                    ->searchable()->sortable()->limit(50)
                    ->description(fn (Article $r) => $r->category),

                Tables\Columns\IconColumn::make('is_breaking')
                    ->label('🔴')
                    ->boolean()
                    ->trueIcon('heroicon-o-fire')
                    ->trueColor('danger')
                    ->falseIcon('heroicon-o-minus')
                    ->falseColor('gray')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Pub.')
                    ->boolean()
                    ->trueColor('success')->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Evid.')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->trueColor('warning')->falseColor('gray'),

                Tables\Columns\TextColumn::make('focus_keyword')
                    ->label('KW')
                    ->badge()->color('gray')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Data')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('post_type')
                    ->label('Tipo')
                    ->options(Article::postTypes()),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Categoria')
                    ->options(array_merge(
                        self::categoriesFor('tourism'),
                        self::categoriesFor('news'),
                        self::categoriesFor('city'),
                        self::categoriesFor('guide'),
                    )),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Stato')
                    ->trueLabel('Pubblicati')
                    ->falseLabel('Bozze'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('In evidenza'),

                Tables\Filters\TernaryFilter::make('is_breaking')
                    ->label('Breaking'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (Article $r) => route('tourism.show', $r->slug))
                    ->openUrlInNewTab()
                    ->tooltip('Anteprima'),

                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Pubblica')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_published' => true, 'published_at' => now()]))
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Metti in bozza')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_published' => false]))
                        ->requiresConfirmation(),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nessun articolo')
            ->emptyStateDescription('Crea il tuo primo articolo.')
            ->emptyStateIcon('heroicon-o-document-text');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    // ═══════════════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════════════

    private static function contentFields(string $locale): array
    {
        $req  = ($locale === 'it');
        $lang = strtoupper($locale);

        return [
            Forms\Components\TextInput::make("title_{$locale}")
                ->label("Titolo ({$lang})")
                ->required($req)->maxLength(255)
                ->live(debounce: 800)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $state) use ($locale) {
                    if ($locale === 'it' && $state && !$get('slug')) {
                        $set('slug', Str::slug($state));
                    }
                })
                ->columnSpanFull(),

            Forms\Components\Textarea::make("excerpt_{$locale}")
                ->label("Excerpt ({$lang})")
                ->required($req)->maxLength(500)->rows(3)
                ->columnSpanFull(),

            Forms\Components\RichEditor::make("body_{$locale}")
                ->label("Corpo ({$lang})")
                ->required($req)
                ->toolbarButtons([
                    'heading', 'bold', 'italic', 'underline', 'strike',
                    'link', 'bulletList', 'orderedList',
                    'blockquote', 'codeBlock', 'h2', 'h3',
                    'undo', 'redo',
                ])
                ->columnSpanFull(),
        ];
    }

    public static function categoriesFor(string $postType): array
    {
        return match ($postType) {
            'tourism' => [
                'natura'      => '🌿 Natura',
                'storia'      => '🏛️ Storia',
                'gastronomia' => '🍝 Gastronomia',
                'mare'        => '🏖️ Mare',
                'borghi'      => '🏘️ Borghi',
                'eventi'      => '🎭 Eventi',
            ],
            'news' => [
                'aeroporto'   => '✈️ Aeroporto',
                'voli'        => '🛫 Voli',
                'turismo'     => '🗺️ Turismo',
                'calabria'    => '🌊 Calabria',
                'servizi'     => '🔧 Servizi',
                'istituzionale' => '🏛️ Istituzionale',
            ],
            'city' => [
                'quartieri'   => '🏙️ Quartieri',
                'storia'      => '📜 Storia',
                'cultura'     => '🎭 Cultura',
                'pratiche'    => '📋 Info Pratiche',
                'trasporti'   => '🚌 Trasporti',
                'shopping'    => '🛍️ Shopping',
            ],
            'guide' => [
                'gastronomia' => '🍝 Dove Mangiare',
                'alloggi'     => '🏨 Dove Dormire',
                'trasporti'   => '🚗 Come Muoversi',
                'attivita'    => '🏄 Attività',
                'itinerari'   => '🗺️ Itinerari',
                'famiglie'    => '👨‍👩‍👧 In Famiglia',
            ],
            default => [],
        };
    }

    private static function charCounter(?string $value, int $max): string
    {
        $len = mb_strlen($value ?? '');
        if ($len === 0) return "0/{$max} caratteri";
        return $len <= $max
            ? "✅ {$len}/{$max} caratteri"
            : "⚠️ {$len}/{$max} — troppo lungo";
    }
}
