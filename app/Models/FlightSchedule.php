<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    protected $fillable = [
        'flight_number',
        'airline_name',
        'airline_iata',
        'type',
        'airport_iata',
        'airport_name',
        'scheduled_time',
        'days_of_week',
        'valid_from',
        'valid_to',
        'terminal',
        'is_active',
    ];

    protected $casts = [
        'days_of_week' => 'array',
        'valid_from'   => 'date',
        'valid_to'     => 'date',
        'is_active'    => 'boolean',
    ];

    // ─────────────────────────────────────────────
    // Scope: voli attivi oggi
    // ─────────────────────────────────────────────

    /**
     * Filtra i voli programmati per oggi:
     * - is_active = true
     * - valid_from <= oggi <= valid_to
     * - il giorno ISO di oggi è nell'array days_of_week
     */
    public function scopeForToday(Builder $query, string $type): Builder
    {
        $today    = Carbon::today();
        $isoDay   = (int) $today->isoFormat('E'); // 1=Lun … 7=Dom

        $todayStr = $today->toDateString(); // '2026-05-22' — confronto puro tra date, senza orario

        return $query
            ->where('type', $type)
            ->where('is_active', true)
            ->where('valid_from', '<=', $todayStr)
            ->where('valid_to', '>=', $todayStr)
            ->whereJsonContains('days_of_week', $isoDay)
            ->orderBy('scheduled_time');
    }

    /**
     * Scope: solo partenze di oggi
     * Uso: FlightSchedule::query()->todayDepartures()->get()
     */
    public function scopeTodayDepartures(Builder $query): Builder
    {
        return $this->scopeForToday($query, 'departure');
    }

    /**
     * Scope: solo arrivi di oggi
     * Uso: FlightSchedule::query()->todayArrivals()->get()
     */
    public function scopeTodayArrivals(Builder $query): Builder
    {
        return $this->scopeForToday($query, 'arrival');
    }

    // ─────────────────────────────────────────────
    // Accessor utili
    // ─────────────────────────────────────────────

    /**
     * Orario formattato HH:MM
     */
    public function getFormattedTimeAttribute(): string
    {
        return Carbon::parse($this->scheduled_time)->format('H:i');
    }

    /**
     * Label giorni della settimana (es. "Lun, Mer, Ven")
     */
    public function getDaysLabelAttribute(): string
    {
        $labels = [1 => 'Lun', 2 => 'Mar', 3 => 'Mer', 4 => 'Gio', 5 => 'Ven', 6 => 'Sab', 7 => 'Dom'];
        return implode(', ', array_map(fn($d) => $labels[$d] ?? $d, $this->days_of_week));
    }
}
