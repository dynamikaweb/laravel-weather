@php
    use DynamikaSolucoesWeb\LaravelWeather\Helpers\WeatherCodeHelper;

    $current = $weather['current_weather'] ?? null;
    $daily   = $weather['daily'] ?? null;

    $daily_time = $daily['time'] ?? [];
    $daily_max  = $daily['temperature_2m_max'] ?? [];
    $daily_min  = $daily['temperature_2m_min'] ?? [];
    $daily_code = $daily['weathercode'] ?? [];
    $backgroundTransparent = $transparent ? 'background-transparent' : '';

    $containerClass = 'weather-widget theme-' . $theme;
@endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons-wind.min.css">
<link rel="stylesheet" href="{{ asset('vendor/dynamikasolucoesweb/weather/css/weather.css') }}">
<script src="{{ asset('vendor/dynamikasolucoesweb/weather/js/weather.js') }}" defer></script>

<div class="{{ $containerClass . ' ' . $backgroundTransparent }}" role="region" aria-label="Previsão do tempo">

    @if($current)
        @php
            $curCode  = (int)$current['weathercode'];
            $curMeta  = WeatherCodeHelper::mapWeatherCode($curCode);
            $curClass = $curMeta['class'];
            $curIcon  = WeatherCodeHelper::renderIcon($curMeta['icon'], 38, "current-icon weather-$curClass");
            $curLabel = $curMeta['label'];
            $curTemp  = round($current['temperature']);

            $todayMax = isset($daily_max[0]) ? round($daily_max[0]) : '-';
            $todayMin = isset($daily_min[0]) ? round($daily_min[0]) : '-';
        @endphp

        <div class="weather-current" aria-live="polite">
            <div class="weather-left">
                <div class="temp">{{ $curTemp }}°C</div>
                <div class="desc">{{ $curLabel }}</div>
                <div class="desc-sub">
                    Máx: {{ $todayMax }}° • Mín: {{ $todayMin }}°
                </div>
            </div>

            <div class="weather-right" aria-hidden="true">
                <div class="icon-wrap">{!! $curIcon !!}</div>
                <div class="wind">Vento: {{ $current['windspeed'] ?? '-' }} km/h</div>
            </div>
        </div>
    @endif

    @if(!empty($daily_time))
        <div class="weather-forecast">
            <h4 class="visually-hidden">Próximos dias</h4>
            <div class="forecast-scroll" role="list">
                @for($i = 0; $i < count($daily_time); $i++)
                    @php
                        $date = date('d/m', strtotime($daily_time[$i]));
                        $wcode = (int)($daily_code[$i] ?? 0);

                        $meta = WeatherCodeHelper::mapWeatherCode($wcode);
                        $class = $meta['class'];
                        $icon  = WeatherCodeHelper::renderIcon($meta['icon'], 38, "day-icon weather-$class");
                        
                        $tMax = isset($daily_max[$i]) ? round($daily_max[$i]) : '--';
                        $tMin = isset($daily_min[$i]) ? round($daily_min[$i]) : '--';
                    @endphp

                    <div class="forecast-item" role="listitem" tabindex="0" data-tooltip="{{ $meta['label'] }}">
                        <div class="f-date">{{ $date }}</div>
                        <div class="f-icon">{!! $icon !!}</div>
                        <div class="f-temps">
                            <span class="f-temp-max">{{ $tMax }}°</span>
                            <span class="f-temp-min">{{ $tMin }}°</span>
                        </div>
                        <div class="f-desc">{{ $meta['label'] }}</div>
                    </div>
                @endfor
            </div>
        </div>
    @endif
</div>

<style>
    .visually-hidden {
        position: absolute !important;
        height: 1px;
        width: 1px;
        overflow: hidden;
        clip: rect(1px, 1px, 1px, 1px);
        white-space: nowrap;
    }
</style>