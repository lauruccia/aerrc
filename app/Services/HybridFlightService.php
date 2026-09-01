<?php

namespace App\Services;

use Illuminate\Support\Collection;

/** Il tabellone pubblico mostra esclusivamente i voli restituiti dai provider live. */
class HybridFlightService
{
    public function __construct(
        protected FlightStatusService $statusService
    ) {}

    // ─────────────────────────────────────────────────────────────
    // API pubblica
    // ─────────────────────────────────────────────────────────────

    public function getDepartures(): Collection
    {
        return collect($this->statusService->getDepartureFeed());
    }

    public function getArrivals(): Collection
    {
        return collect($this->statusService->getArrivalFeed());
    }

    public function isLiveAvailable(string $type): bool
    {
        return $this->statusService->isFeedAvailable($type);
    }

    public function getLiveUpdatedAt(string $type): string
    {
        return $this->statusService->getFeedUpdatedAt($type);
    }

}
