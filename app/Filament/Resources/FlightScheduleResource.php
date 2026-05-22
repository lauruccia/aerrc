<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightScheduleResource\Pages;
use App\Models\FlightSchedule;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FlightScheduleResource extends Resource
{
    protected static ?string $model = FlightSchedule::class;

    protected static ?string $navigationIcon  = 'heroicon-o-paper-airplane';
    protected static ?string $navigationLabel = 'Orari Voli';
    protected static ?string $navigationGroup = 'Aeroporto';
    protected static ?int    $navigationSort  = 1;

    protected static ?string $modelLabel       = 'Orario Volo';
    protected static ?string $pluralModelLabel = 'Orari Voli';

    // ─────────────────────────────────────────────────────────────
    // FORM — Crea / Modifica un orario volo
    // ─────────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Dati Volo')
                ->columns(2)
                ->schema([

                    Forms\Components\TextInput::make('flight_number')
                        ->label('Numero Volo')
                        ->placeholder('FR4398')
                        ->required()
                        ->maxLength(10)
                        ->helperText('Senza spazi — es. FR4398, AZ1589'),

                    Forms\Components\TextInput::make('airline_name')
                        ->label('Compagnia Aerea')
                        ->placeholder('Ryanair')
                        ->required()
                        ->maxLength(60),

                    Forms\Components\TextInput::make('airline_iata')
                        ->label('Codice IATA Compagnia')
                        ->placeholder('FR')
                        ->required()
                        ->maxLength(3)
                        ->helperText('2 lettere — es. FR, AZ, U2'),

                    Forms\Components\Select::make('type')
                        ->label('Tipo')
                        ->options([
                            'departure' => '✈ Partenza da REG',
                            'arrival'   => '↓ Arrivo a REG',
                        ])
                        ->required(),
                ]),

            Forms\Components\Section::make('Aeroporto Remoto')
                ->columns(2)
                ->schema([

                    Forms\Components\TextInput::make('airport_iata')
                        ->label('Codice IATA Aeroporto')
                        ->placeholder('MXP')
                        ->required()
                        ->maxLength(4)
                        ->helperText('es. MXP, FCO, STN, BCN'),

                    Forms\Components\TextInput::make('airport_name')
                        ->label('Nome Aeroporto / Città')
                        ->placeholder('Milano Malpensa')
                        ->required()
                        ->maxLength(80),
                ]),

            Forms\Components\Section::make('Orario e Giorni')
                ->columns(2)
                ->schema([

                    Forms\Components\TimePicker::make('scheduled_time')
                        ->label('Orario Programmato')
                        ->seconds(false)
                        ->required(),

                    Forms\Components\CheckboxList::make('days_of_week')
                        ->label('Giorni della Settimana')
                        ->options([
                            1 => 'Lunedì',
                            2 => 'Martedì',
                            3 => 'Mercoledì',
                            4 => 'Giovedì',
                            5 => 'Venerdì',
                            6 => 'Sabato',
                            7 => 'Domenica',
                        ])
                        ->columns(4)
                        ->required()
                        ->helperText('Seleziona i giorni in cui opera il volo'),
                ]),

            Forms\Components\Section::make('Validità Stagionale')
                ->columns(2)
                ->schema([

                    Forms\Components\DatePicker::make('valid_from')
                        ->label('Valido Dal')
                        ->required()
                        ->displayFormat('d/m/Y')
                        ->helperText('Inizio stagione IATA'),

                    Forms\Components\DatePicker::make('valid_to')
                        ->label('Valido Al')
                        ->required()
                        ->displayFormat('d/m/Y')
                        ->helperText('Fine stagione IATA'),
                ]),

            Forms\Components\Section::make('Info Aggiuntive')
                ->columns(2)
                ->schema([

                    Forms\Components\TextInput::make('terminal')
                        ->label('Terminal')
                        ->placeholder('1')
                        ->maxLength(5)
                        ->nullable(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Volo Attivo')
                        ->default(true)
                        ->helperText('Disattiva per nascondere il volo senza eliminarlo'),
                ]),
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // TABLE — Lista orari voli
    // ─────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        $todayIso = (int) Carbon::today()->isoFormat('E');

        return $table
            ->defaultSort('scheduled_time')
            ->columns([

                Tables\Columns\TextColumn::make('flight_number')
                    ->label('Volo')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipo')
                    ->colors([
                        'success' => 'departure',
                        'info'    => 'arrival',
                    ])
                    ->formatStateUsing(fn($state) => $state === 'departure' ? '✈ Partenza' : '↓ Arrivo'),

                Tables\Columns\TextColumn::make('airline_name')
                    ->label('Compagnia')
                    ->searchable(),

                Tables\Columns\TextColumn::make('airport_name')
                    ->label('Aeroporto')
                    ->searchable()
                    ->description(fn($record) => $record->airport_iata),

                Tables\Columns\TextColumn::make('scheduled_time')
                    ->label('Orario')
                    ->sortable()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('H:i')),

                Tables\Columns\TextColumn::make('days_of_week')
                    ->label('Giorni')
                    ->formatStateUsing(fn($record) => $record->days_label)
                    ->wrap(),

                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Da')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('valid_to')
                    ->label('A')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Attivo')
                    ->boolean(),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'departure' => '✈ Partenze',
                        'arrival'   => '↓ Arrivi',
                    ]),

                Tables\Filters\SelectFilter::make('airline_iata')
                    ->label('Compagnia')
                    ->options([
                        'FR' => 'Ryanair',
                        'AZ' => 'ITA Airways',
                        'U2' => 'easyJet',
                        'VY' => 'Vueling',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Solo attivi'),

                Tables\Filters\Filter::make('oggi')
                    ->label('Operativi oggi')
                    ->query(fn($query) => $query
                        ->where('is_active', true)
                        ->where('valid_from', '<=', Carbon::today())
                        ->where('valid_to', '>=', Carbon::today())
                        ->whereJsonContains('days_of_week', $todayIso)
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->label('Duplica')
                    ->beforeReplicaSaved(function (FlightSchedule $replica) {
                        $replica->is_active = false; // duplicato parte come inattivo
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('disattiva')
                        ->label('Disattiva selezionati')
                        ->icon('heroicon-o-eye-slash')
                        ->action(fn($records) => $records->each->update(['is_active' => false])),
                    Tables\Actions\BulkAction::make('attiva')
                        ->label('Attiva selezionati')
                        ->icon('heroicon-o-eye')
                        ->action(fn($records) => $records->each->update(['is_active' => true])),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('svuota_cache')
                    ->label('🔄 Svuota cache stato voli')
                    ->color('warning')
                    ->action(function () {
                        $iata = config('aviationstack.airport_iata', 'REG');
                        cache()->forget("flight_status.departure.{$iata}");
                        cache()->forget("flight_status.arrival.{$iata}");
                    })
                    ->successNotificationTitle('Cache svuotata — prossima visita ricaricherà lo stato live'),
            ]);
    }

    // ─────────────────────────────────────────────────────────────
    // PAGES
    // ─────────────────────────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFlightSchedules::route('/'),
            'create' => Pages\CreateFlightSchedule::route('/create'),
            'edit'   => Pages\EditFlightSchedule::route('/{record}/edit'),
        ];
    }
}
