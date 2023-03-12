<?php

namespace App\Infrastructure\Services\OpenWeather;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\ParameterBag;
use function config;

final class OpenWeatherApiClient implements OpenWeatherApiClientInterface
{
    public function __construct(
        public readonly PendingRequest $client
    ) {
    }

    /**
     * @param ParameterBag $parameters
     * @return array|null
     */
    public function getWeather(ParameterBag $parameters): ?array
    {
        $response = $this->client
            ->get(sprintf(
                '%s%s?appid=%s&lat=%s&lon=%s&units=metric',
                config('weathers.openweather.base_url'),
                config('weathers.openweather.current_weather'),
                config('weathers.openweather.api_key'),
                $parameters->get('lat'),
                $parameters->get('lon'),
            ));


        if (! $response->successful()) {
            Log::error(sprintf(
                'OpenWeatherApiClient::getWeather with lat %s and lon %s: %s response: %s',
                $parameters->get('lat'),
                $parameters->get('lon'),
                $response->status(),
                $response->body(),
            ));

            return null;
        }

        $weather = $response->json();

        if (
            ! isset($weather['weather'][0], $weather['main'], $weather['wind']) ||
            empty($weather)
        ) {
            return null;
        }

        return $weather;
    }
}
