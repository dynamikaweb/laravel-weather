@php
    use DynamikaSolucoesWeb\LaravelWeather\Helpers\WeatherCodeHelper;

    $current = $weather['current_weather'] ?? null;
    $daily   = $weather['daily'] ?? null;

    $backgroundTransparent = $transparent ? 'background-transparent' : '';
    $containerClass = 'weather-widget-compact theme-' . $theme . ' ' . $backgroundTransparent;
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons-wind.min.css">
<link rel="stylesheet" href="{{ asset('vendor/dynamikasolucoesweb/weather/css/weather.css') }}">
<script src="{{ asset('vendor/dynamikasolucoesweb/weather/js/weather.js') }}" defer></script>

<div class="{{ $containerClass }}" role="region" aria-label="Clima atual">

    @if($current)
        @php
            $curCode  = (int)$current['weathercode'];
            $curMeta  = WeatherCodeHelper::mapWeatherCode($curCode);
            $curClass = $curMeta['class'];
            $curIcon  = WeatherCodeHelper::renderIcon($curMeta['icon'], 38, "current-icon weather-$curClass");
            $curLabel = $curMeta['label'];
            $curTemp  = round($current['temperature']);

            $todayMax = isset($daily['temperature_2m_max'][0]) ? round($daily['temperature_2m_max'][0]) : '-';
            $todayMin = isset($daily['temperature_2m_min'][0]) ? round($daily['temperature_2m_min'][0]) : '-';
        @endphp

        <div class="compact-wrap">
            <div class="c-left">
                <div class="c-temp">{{ $curTemp }}°C</div>
                <div class="c-desc">{{ $curLabel }}</div>
                <div class="c-range">↑{{ $todayMax }}° ↓{{ $todayMin }}°</div>
            </div>

            <div class="c-right" aria-hidden="true">
                <div class="c-icon">{!! $curIcon !!}</div>
            </div>
        </div>
    @else
        <div class="compact-no-data">Sem dados</div>
    @endif
</div>