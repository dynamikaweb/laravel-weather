<?php

namespace DynamikaSolucoesWeb\LaravelWeather\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
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
        return Cache::remember($this->cacheKey, $this->cacheDuration, function () {
            $url = "https://api.open-meteo.com/v1/forecast";

            try {
                $response = Http::timeout(5)->withoutVerifying()->get($url, [
                    'latitude' => $this->lat,
                    'longitude' => $this->lng,
                    'current_weather' => 'true',
                    'daily' => 'weathercode,temperature_2m_max,temperature_2m_min',
                    'timezone' => 'auto',
                    'forecast_days' => $this->dias,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                return [
                    'error' => true,
                    'message' => 'Resposta inválida da API Open-Meteo.',
                ];

            } catch (\Exception $e) {
                return [
                    'error' => true,
                    'message' => 'Não foi possível conectar à API Open-Meteo: ' . $e->getMessage(),
                ];
            }
        });
    }
}