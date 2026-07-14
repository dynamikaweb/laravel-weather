<?php

namespace DynamikaSolucoesWeb\LaravelWeather\Helpers;

class WeatherCodeHelper
{
    public static function mapWeatherCode(int $code): array
    {
        $map = [
            0  => ['label' => 'Céu limpo',                    'icon' => 'day-sunny',        'class' => 'sunny'],
            1  => ['label' => 'Predominantemente claro',      'icon' => 'day-sunny-overcast','class' => 'partly'],
            2  => ['label' => 'Parcialmente nublado',         'icon' => 'day-cloudy',       'class' => 'partly'],
            3  => ['label' => 'Nublado',                      'icon' => 'cloudy',           'class' => 'cloudy'],
            45 => ['label' => 'Nevoeiro',                     'icon' => 'fog',              'class' => 'foggy'],
            48 => ['label' => 'Nevoeiro com geada',           'icon' => 'fog',              'class' => 'foggy'],
            51 => ['label' => 'Garoa leve',                   'icon' => 'sprinkle',         'class' => 'rainy'],
            53 => ['label' => 'Garoa moderada',               'icon' => 'sprinkle',         'class' => 'rainy'],
            55 => ['label' => 'Garoa intensa',                'icon' => 'sprinkle',         'class' => 'rainy'],
            61 => ['label' => 'Chuva leve',                   'icon' => 'rain',             'class' => 'rainy'],
            63 => ['label' => 'Chuva moderada',               'icon' => 'rain',             'class' => 'rainy'],
            65 => ['label' => 'Chuva forte',                  'icon' => 'rain-wind',        'class' => 'rainy'],
            80 => ['label' => 'Pancadas de chuva fracas',     'icon' => 'showers',          'class' => 'rainy'],
            81 => ['label' => 'Pancadas de chuva',            'icon' => 'showers',          'class' => 'rainy'],
            82 => ['label' => 'Pancadas de chuva fortes',     'icon' => 'storm-showers',    'class' => 'rainy'],
            95 => ['label' => 'Trovoadas',                    'icon' => 'thunderstorm',     'class' => 'stormy'],
            96 => ['label' => 'Trovoadas com granizo leve',   'icon' => 'hail',             'class' => 'stormy'],
            99 => ['label' => 'Trovoadas com granizo forte',  'icon' => 'hail',             'class' => 'stormy'],
        ];

        return $map[$code] ?? [
            'label' => 'Desconhecido',
            'icon'  => 'na',
            'class' => 'cloudy'
        ];
    }

    public static function renderIcon(string $icon, int $size = 38, string $extra = ''): string
    {
        $cls = trim("wi wi-$icon $extra");
        return '<i class="'.e($cls).'" style="font-size:'.$size.'px"></i>';
    }
}