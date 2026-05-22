<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Response;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static ?string $navigationIcon  = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Newsletter';
    protected static ?string $navigationGroup = 'Commerciale';
    protected static ?int    $navigationSort  = 2;

    protected static ?string $modelLabel       = 'Iscritto';
    protected static ?string $pluralModelLabel = 'Iscritti Newsletter';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()->required()->maxLength(255),

                Forms\Components\Select::make('locale')
                    ->label('Lingua preferita')
                    ->options(['it' => '🇮🇹 Italiano', 'en' => '🇬🇧 English', 'de' => '🇩🇪 Deutsch', 'fr' => '🇫🇷 Français'])
                    ->default('it')
                    ->native(false),

                Forms\Components\Toggle::make('is_active')
                    ->label('Attivo (non disiscritta)')
                    ->default(true)
                    ->onColor('success'),

                Forms\Components\DateTimePicker::make('subscribed_at')
                    ->label('Data iscrizione')
                    ->default(now())
                    ->native(false),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()->sortable()->copyable(),

                Tables\Columns\TextColumn::make('locale')
                    ->label('Lingua')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'it' => '🇮🇹 IT', 'en' => '🇬🇧 EN',
                        'de' => '🇩🇪 DE', 'fr' => '🇫🇷 FR',
                        default => $state,
                    })
                    ->color('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean()->trueColor('success')->falseColor('gray'),

                Tables\Columns\TextColumn::make('subscribed_at')
                    ->label('Iscritto il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrato')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('subscribed_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Stato')
                    ->trueLabel('Attivi')
                    ->falseLabel('Disiscritti'),
                Tables\Filters\SelectFilter::make('locale')
                    ->label('Lingua')
                    ->options(['it' => 'Italiano', 'en' => 'English', 'de' => 'Deutsch', 'fr' => 'Français']),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportCsv')
                    ->label('Esporta CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function () {
                        $subscribers = NewsletterSubscriber::where('is_active', true)
                            ->orderBy('subscribed_at', 'desc')
                            ->get(['email', 'locale', 'subscribed_at']);

                        $csv = "email,lingua,data_iscrizione\n";
                        foreach ($subscribers as $s) {
                            $csv .= "{$s->email},{$s->locale},{$s->subscribed_at}\n";
                        }

                        return Response::streamDownload(
                            fn () => print($csv),
                            'newsletter_iscritti_' . now()->format('Y-m-d') . '.csv',
                            ['Content-Type' => 'text/csv']
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleActive')
                    ->label('')
                    ->icon(fn (NewsletterSubscriber $r) => $r->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (NewsletterSubscriber $r) => $r->is_active ? 'warning' : 'success')
                    ->tooltip(fn (NewsletterSubscriber $r) => $r->is_active ? 'Disiscrivi' : 'Reiscrivi')
                    ->action(fn (NewsletterSubscriber $r) => $r->update(['is_active' => !$r->is_active])),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Disiscrivi selezionati')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nessun iscritto')
            ->emptyStateIcon('heroicon-o-envelope');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletterSubscribers::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return true;
    }
}
