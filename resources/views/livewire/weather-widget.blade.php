<div class="bg-gradient-to-br from-sky to-navy rounded-2xl p-8 text-white text-center">
    <h3 class="font-bold text-lg mb-4 opacity-80">
        🌡️ {{ __('airport.weather_title') }}
    </h3>

    <div class="text-7xl mb-2">{{ $weather['icon'] ?? '☀️' }}</div>
    <div class="text-6xl font-black mb-1">{{ $weather['temp'] ?? '--' }}°C</div>
    <div class="text-sm opacity-80 mb-6">{{ $weather['desc'] ?? '' }}</div>

    <div class="grid grid-cols-3 gap-3">
        <div class="bg-white/10 rounded-xl p-3">
            <div class="text-lg font-bold">💧 {{ $weather['humidity'] ?? '--' }}%</div>
            <div class="text-xs opacity-70 mt-1">Umidità</div>
        </div>
        <div class="bg-white/10 rounded-xl p-3">
            <div class="text-lg font-bold">💨 {{ $weather['wind'] ?? '--' }} km/h</div>
            <div class="text-xs opacity-70 mt-1">Vento</div>
        </div>
        <div class="bg-white/10 rounded-xl p-3">
            <div class="text-lg font-bold">✈️ REG</div>
            <div class="text-xs opacity-70 mt-1">IATA</div>
        </div>
    </div>
</div>
