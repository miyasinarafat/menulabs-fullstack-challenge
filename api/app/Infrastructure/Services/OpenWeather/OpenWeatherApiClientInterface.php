<?php

namespace App\Infrastructure\Services\OpenWeather;

use Symfony\Component\HttpFoundation\ParameterBag;

interface OpenWeatherApiClientInterface
{
    /**
     * @param ParameterBag $parameters
     * @return array|null
     */
    public function getWeather(ParameterBag $parameters): ?array;
}
