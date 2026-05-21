<?php

namespace App\Livewire;

use App\Services\AviationStackService;
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
        cache()->forget("flights.departures.REG");
        cache()->forget("flights.arrivals.REG");
        $this->lastUpdate = now()->format('H:i');
    }

    /**
     * Chiamato automaticamente da wire:poll — aggiorna solo se autoRefresh attivo.
     */
    public function poll(): void
    {
        if ($this->autoRefresh) {
            cache()->forget("flights.{$this->tab}.REG");
            $this->lastUpdate = now()->format('H:i');
        }
    }

    public function toggleAutoRefresh(): void
    {
        $this->autoRefresh = ! $this->autoRefresh;
    }

    public function render(AviationStackService $service)
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
