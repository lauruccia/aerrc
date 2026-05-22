<?php

namespace App\Livewire;

use App\Services\HybridFlightService;
use Livewire\Attributes\On;
use Livewire\Component;

class FlightBoard extends Component
{
    public string $tab        = 'departures';
    public string $lastUpdate = '';
    public bool   $autoRefresh = true;

    // Polling automatico ogni 60 secondi (Livewire 3)
    protected int $pollInterval = 60000; // ms

    public function mount(): void
    {
        $this->lastUpdate = now()->format('H:i');
    }

    public function switchTab(string $tab): void
    {
        if (! in_array($tab, ['departures', 'arrivals'])) return;

        $this->tab = $tab;
        $this->lastUpdate = now()->format('H:i');
    }

    /**
     * Refresh manuale: svuota la cache e rilascia una nuova fetch.
     */
    public function refresh(): void
    {
        // Svuota sia la cache degli orari DB (non necessaria, sono statici)
        // sia la cache dello stato live API
        $iata = config('aviationstack.airport_iata', 'REG');
        cache()->forget("flight_status.departure.{$iata}");
        cache()->forget("flight_status.arrival.{$iata}");
        $this->lastUpdate = now()->format('H:i');
    }

    /**
     * Chiamato automaticamente da wire:poll — aggiorna stato live se autoRefresh attivo.
     */
    public function poll(): void
    {
        if ($this->autoRefresh) {
            $this->lastUpdate = now()->format('H:i');
            // Il render rilancia HybridFlightService che usa la cache interna
        }
    }

    public function toggleAutoRefresh(): void
    {
        $this->autoRefresh = ! $this->autoRefresh;
    }

    public function render(HybridFlightService $service)
    {
        $flights = match($this->tab) {
            'arrivals' => $service->getArrivals(),
            default    => $service->getDepartures(),
        };

        return view('livewire.flight-board', [
            'flights'      => $flights,
            'lastUpdate'   => $this->lastUpdate,
            'autoRefresh'  => $this->autoRefresh,
            'pollInterval' => $this->pollInterval,
        ]);
    }
}
