<?php

namespace App\Infrastructure\Persistance;

use App\Models\Weather;

interface WeatherRepositoryInterface
{
    /**
     * @param Weather $weather
     * @return Weather|null
     */
    public function update(Weather $weather): ?Weather;

    /**
     * @param int $userId
     * @return Weather|null
     */
    public function getByUserId(int $userId): ?Weather;
}
