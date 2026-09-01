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
    public bool   $liveAvailable = false;

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
    }

    /** Aggiorna la vista usando il feed in cache, senza consumare quota extra. */
    public function refresh(): void
    {
        // Il render rilegge il feed; la cache impedisce chiamate API aggiuntive.
    }

    /**
     * Chiamato automaticamente da wire:poll — aggiorna stato live se autoRefresh attivo.
     */
    public function poll(): void
    {
        if ($this->autoRefresh) {
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
        $feedType = $this->tab === 'arrivals' ? 'arrival' : 'departure';
        $this->liveAvailable = $service->isLiveAvailable($feedType);
        $this->lastUpdate = $service->getLiveUpdatedAt($feedType);

        return view('livewire.flight-board', [
            'flights'      => $flights,
            'lastUpdate'   => $this->lastUpdate,
            'autoRefresh'  => $this->autoRefresh,
            'liveAvailable' => $this->liveAvailable,
            'pollInterval' => $this->pollInterval,
        ]);
    }
}
