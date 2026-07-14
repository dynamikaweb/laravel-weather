<?php

namespace DynamikaSolucoesWeb\LaravelWeather\Components;

use Illuminate\View\Component;
use DynamikaSolucoesWeb\LaravelWeather\Services\WeatherService;

class WeatherWidget extends Component
{
    public $lat;
    public $lng;
    public $dias;
    public $cacheDuration;
    public $theme;
    public $compact;
    public $transparent;
    public $weather;

    public function __construct(
        $lat,
        $lng,
        $dias = 4,
        $cacheDuration = 900,
        $theme = 'dark',
        $compact = false,
        $transparent = false
    ) {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->dias = $compact ? 1 : $dias;
        $this->cacheDuration = $cacheDuration;
        $this->theme = $theme;
        $this->compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
        $this->transparent = filter_var($transparent, FILTER_VALIDATE_BOOLEAN);

        $service = new WeatherService($this->lat, $this->lng, $this->dias, $this->cacheDuration);
        $this->weather = $service->getForecast();
    }

    public function render()
    {
        $view = $this->compact ? 'weather::components.compact' : 'weather::components.index';

        return view($view, [
            'weather' => $this->weather,
            'theme' => $this->theme,
            'transparent' => $this->transparent,
        ]);
    }
}