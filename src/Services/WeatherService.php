<?php

namespace DynamikaSolucoesWeb\LaravelWeather\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private const ERROR_CACHE_SECONDS = 60;

    private float $lat;
    private float $lng;
    private int $dias;
    private int $cacheDuration;
    private string $cacheKey;

    public function __construct(float $lat, float $lng, ?int $dias = 4, ?int $cacheDuration = 900)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->dias = max(1, min($dias ?? 4, 16));
        $this->cacheDuration = $cacheDuration ?? 900;
        $this->cacheKey = "weather_{$lat}_{$lng}_{$this->dias}";
    }

    public function getForecast(): array
    {
        $cached = Cache::get($this->cacheKey);

        if (is_array($cached)) {
            return $cached;
        }

        $forecast = $this->fetch();

        Cache::put(
            $this->cacheKey,
            $forecast,
            isset($forecast['error']) ? self::ERROR_CACHE_SECONDS : $this->cacheDuration
        );

        return $forecast;
    }

    private function fetch(): array
    {
        try {
            $response = Http::connectTimeout(3)->timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $this->lat,
                'longitude' => $this->lng,
                'current_weather' => 'true',
                'daily' => 'weathercode,temperature_2m_max,temperature_2m_min',
                'timezone' => 'auto',
                'forecast_days' => $this->dias,
            ]);
        } catch (\Throwable $e) {
            return [
                'error' => true,
                'message' => 'Não foi possível conectar à API Open-Meteo: ' . $e->getMessage(),
            ];
        }

        if ($response->successful() && is_array($response->json())) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => 'Resposta inválida da API Open-Meteo.',
        ];
    }
}
