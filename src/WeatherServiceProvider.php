<?php

namespace DynamikaSolucoesWeb\LaravelWeather;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use DynamikaSolucoesWeb\LaravelWeather\Components\WeatherWidget;

class WeatherServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'weather');

        Blade::component('weather-widget', WeatherWidget::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/dynamikasolucoesweb/weather'),
            ], 'weather-assets');
        }
    }
}