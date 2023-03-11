<?php

namespace App\Infrastructure\Persistance;

use App\Infrastructure\Cache\Cache;
use App\Infrastructure\Cache\CacheTag;
use App\Models\Weather;

final class WeatherRepository implements WeatherRepositoryInterface
{
    public const CACHE_TAGS = [CacheTag::WEATHER];

    /**
     * @inheritDoc
     */
    public function update(Weather $weather): ?Weather
    {
        /** @var Weather $dbWeather */
        $dbWeather = Weather::query()->updateOrCreate([
            'user_id' => $weather->user_id,
        ], [
            'user_id' => $weather->user_id,
            'status' => $weather->status,
            'description' => $weather->description,
            'temperature' => $weather->temperature,
            'temperature_min' => $weather->temperature_min,
            'temperature_max' => $weather->temperature_max,
            'humidity' => $weather->humidity,
            'visibility' => $weather->visibility,
            'wind_speed' => $weather->wind_speed,
            'city' => $weather->city,
            'country' => $weather->country,
            'icon' => $weather->icon,
            'datetime' => $weather->datetime,
        ]);

        if (! $dbWeather->save()) {
            return null;
        }

        Cache::flushCache(Cache::generateCacheKey('weather', (string)$weather->user_id));

        return $dbWeather;
    }

    /**
     * @inheritDoc
     */
    public function getByUserId(int $userId): ?Weather
    {
        $cacheKey = Cache::generateCacheKey('weather', (string)$userId);

        /** @var Weather $result */
        if (! $result = Cache::readCache($cacheKey, self::CACHE_TAGS)) {
            $result = Weather::query()->where('user_id', $userId)->first();

            Cache::writePermanently($cacheKey, $result, self::CACHE_TAGS);
        }

        return $result;
    }
}
