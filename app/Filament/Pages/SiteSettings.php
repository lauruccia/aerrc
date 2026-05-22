<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Impostazioni Sito';
    protected static ?string $navigationGroup = 'Impostazioni';
    protected static ?int    $navigationSort  = 1;
    protected static string  $view            = 'filament.pages.site-settings';

    public array $data = [];

    public function mount(): void
    {
        // Carica tutte le impostazioni esistenti nel form
        $settings = SiteSetting::query()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Impostazioni')
                    ->tabs([

                        // ── Homepage ────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('🏠 Homepage')
                            ->schema([
                                Forms\Components\Section::make('Hero principale')
                                    ->description('Testo mostrato nell\'hero della homepage')
                                    ->schema([
                                        Forms\Components\Textarea::make('hero_title')
                                            ->label('Titolo Hero')
                                            ->rows(3)
                                            ->helperText('Usa \\n per andare a capo'),

                                        Forms\Components\Textarea::make('hero_subtitle')
                                            ->label('Sottotitolo Hero')
                                            ->rows(2),

                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('hero_cta_primary')
                                                ->label('CTA Primario (testo)')
                                                ->placeholder('Consulta i Voli'),

                                            Forms\Components\TextInput::make('hero_cta_secondary')
                                                ->label('CTA Secondario (testo)')
                                                ->placeholder('Scopri la Calabria'),
                                        ]),
                                    ]),

                                Forms\Components\Section::make('Banner avvisi')
                                    ->description('Banner di avviso in cima alla homepage (scioperi, notizie urgenti)')
                                    ->schema([
                                        Forms\Components\Toggle::make('banner_active')
                                            ->label('Mostra banner')
                                            ->onColor('warning'),

                                        Forms\Components\Textarea::make('banner_text')
                                            ->label('Testo banner')
                                            ->rows(2)
                                            ->placeholder('⚠️ Sciopero nazionale il 15 giugno...'),

                                        Forms\Components\ColorPicker::make('banner_color')
                                            ->label('Colore sfondo banner')
                                            ->default('#C9A84C'),
                                    ]),
                            ]),

                        // ── Contatti ────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('📞 Contatti')
                            ->schema([
                                Forms\Components\Section::make('Recapiti')
                                    ->schema([
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('contact_email')
                                                ->label('Email principale')
                                                ->email()
                                                ->prefixIcon('heroicon-o-envelope'),

                                            Forms\Components\TextInput::make('contact_phone')
                                                ->label('Telefono')
                                                ->tel()
                                                ->prefixIcon('heroicon-o-phone'),

                                            Forms\Components\TextInput::make('whatsapp_number')
                                                ->label('WhatsApp (con prefisso +39)')
                                                ->placeholder('+39 333 1234567')
                                                ->prefixIcon('heroicon-o-chat-bubble-left'),

                                            Forms\Components\Textarea::make('contact_address')
                                                ->label('Indirizzo')
                                                ->rows(2),
                                        ]),
                                    ]),
                            ]),

                        // ── Social ──────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('📱 Social')
                            ->schema([
                                Forms\Components\Section::make('Profili social')
                                    ->schema([
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('social_facebook')
                                                ->label('Facebook')
                                                ->url()->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://facebook.com/...')
                                                ->prefixIconColor('primary'),

                                            Forms\Components\TextInput::make('social_instagram')
                                                ->label('Instagram')
                                                ->url()->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://instagram.com/...'),

                                            Forms\Components\TextInput::make('social_twitter')
                                                ->label('X / Twitter')
                                                ->url()->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://x.com/...'),

                                            Forms\Components\TextInput::make('social_linkedin')
                                                ->label('LinkedIn')
                                                ->url()->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://linkedin.com/...'),

                                            Forms\Components\TextInput::make('social_youtube')
                                                ->label('YouTube')
                                                ->url()->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://youtube.com/...'),

                                            Forms\Components\TextInput::make('social_tiktok')
                                                ->label('TikTok')
                                                ->url()->prefixIcon('heroicon-o-globe-alt')
                                                ->placeholder('https://tiktok.com/@...'),
                                        ]),
                                    ]),
                            ]),

                        // ── SEO & Analytics ─────────────────────────────
                        Forms\Components\Tabs\Tab::make('🔍 SEO & Analytics')
                            ->schema([
                                Forms\Components\Section::make('SEO Globale')
                                    ->schema([
                                        Forms\Components\TextInput::make('seo_site_name')
                                            ->label('Nome sito (og:site_name)')
                                            ->maxLength(100),

                                        Forms\Components\Textarea::make('seo_default_desc')
                                            ->label('Meta description globale')
                                            ->rows(3)
                                            ->maxLength(165)
                                            ->helperText('Usata quando la pagina non ha una descrizione specifica'),

                                        Forms\Components\TextInput::make('seo_og_image')
                                            ->label('OG Image globale (URL)')
                                            ->url()
                                            ->prefixIcon('heroicon-o-photo')
                                            ->helperText('Immagine di default per condivisioni social'),
                                    ]),

                                Forms\Components\Section::make('Analytics & Pixel')
                                    ->schema([
                                        Forms\Components\Grid::make(3)->schema([
                                            Forms\Components\TextInput::make('ga_id')
                                                ->label('Google Analytics ID')
                                                ->placeholder('G-XXXXXXXXXX')
                                                ->helperText('Inizia con G-'),

                                            Forms\Components\TextInput::make('gtm_id')
                                                ->label('Google Tag Manager ID')
                                                ->placeholder('GTM-XXXXXXX'),

                                            Forms\Components\TextInput::make('fb_pixel_id')
                                                ->label('Facebook Pixel ID')
                                                ->placeholder('1234567890'),
                                        ]),

                                        Forms\Components\Toggle::make('cookie_banner_active')
                                            ->label('Mostra banner cookie GDPR')
                                            ->onColor('success')
                                            ->helperText('Disattiva solo se usi un CMP esterno'),
                                    ]),
                            ]),

                        // ── Testi UI ────────────────────────────────────
                        Forms\Components\Tabs\Tab::make('✏️ Testi & UI')
                            ->schema([
                                Forms\Components\Section::make('Footer')
                                    ->description('Testi mostrati nel footer del sito')
                                    ->schema([
                                        Forms\Components\Textarea::make('footer_tagline_it')
                                            ->label('Tagline footer (IT)')
                                            ->rows(2)
                                            ->placeholder('Il portale ufficiale del turismo calabrese...'),
                                        Forms\Components\Textarea::make('footer_tagline_en')
                                            ->label('Tagline footer (EN)')
                                            ->rows(2),
                                        Forms\Components\TextInput::make('footer_copyright')
                                            ->label('Copyright')
                                            ->placeholder('© 2025 aeroportoreggiocalabria.it — Tutti i diritti riservati'),
                                    ]),

                                Forms\Components\Section::make('Sezione Newsletter')
                                    ->schema([
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('newsletter_title_it')
                                                ->label('Titolo sezione newsletter (IT)')
                                                ->placeholder('Resta aggiornato'),
                                            Forms\Components\TextInput::make('newsletter_title_en')
                                                ->label('Newsletter title (EN)')
                                                ->placeholder('Stay updated'),
                                        ]),
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\Textarea::make('newsletter_desc_it')
                                                ->label('Descrizione (IT)')
                                                ->rows(2)
                                                ->placeholder('Ricevi le ultime news su voli, turismo e offerte...'),
                                            Forms\Components\Textarea::make('newsletter_desc_en')
                                                ->label('Description (EN)')
                                                ->rows(2),
                                        ]),
                                    ]),

                                Forms\Components\Section::make('Sezione Hero — CTA link')
                                    ->schema([
                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('hero_cta_primary_url')
                                                ->label('URL CTA Primario')
                                                ->placeholder('/voli')
                                                ->prefixIcon('heroicon-o-link'),
                                            Forms\Components\TextInput::make('hero_cta_secondary_url')
                                                ->label('URL CTA Secondario')
                                                ->placeholder('/turismo')
                                                ->prefixIcon('heroicon-o-link'),
                                        ]),
                                    ]),
                            ]),

                        // ── Manutenzione ─────────────────────────────────
                        Forms\Components\Tabs\Tab::make('🔧 Manutenzione')
                            ->schema([
                                Forms\Components\Section::make('Modalità manutenzione')
                                    ->schema([
                                        Forms\Components\Toggle::make('maintenance_mode')
                                            ->label('Attiva modalità manutenzione')
                                            ->helperText('⚠️ Il sito pubblico mostrerà una pagina di manutenzione')
                                            ->onColor('danger'),
                                        Forms\Components\Textarea::make('maintenance_message_it')
                                            ->label('Messaggio manutenzione (IT)')
                                            ->rows(3)
                                            ->placeholder('Sito in manutenzione, torneremo presto online...'),
                                        Forms\Components\Textarea::make('maintenance_message_en')
                                            ->label('Maintenance message (EN)')
                                            ->rows(3)
                                            ->placeholder('Site under maintenance, we\'ll be back soon...'),
                                    ]),

                                Forms\Components\Section::make('Script personalizzati')
                                    ->schema([
                                        Forms\Components\Textarea::make('custom_head_scripts')
                                            ->label('Script extra <head>')
                                            ->rows(4)
                                            ->helperText('Codice HTML/JS inserito nel <head> — es. verifica Google Search Console'),
                                        Forms\Components\Textarea::make('custom_body_scripts')
                                            ->label('Script extra prima di </body>')
                                            ->rows(4)
                                            ->helperText('Codice HTML/JS inserito prima della chiusura del body'),
                                    ]),
                            ]),

                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salva impostazioni')
                ->icon('heroicon-o-check')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Normalizza i boolean (toggle restituisce true/false)
        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $data[$key] = $value ? '1' : '0';
            }
        }

        SiteSetting::setMany($data);

        Notification::make()
            ->title('Impostazioni salvate')
            ->success()
            ->send();
    }
}
