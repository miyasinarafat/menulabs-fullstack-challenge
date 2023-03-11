<?php

namespace App\Http\Resources;

use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Weather $resource
 */
class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'status' => $this->resource->status,
            'description' => $this->resource->description,
            'temperature' => $this->resource->temperature,
            'temperatureMin' => $this->resource->temperature_min,
            'temperatureMax' => $this->resource->temperature_max,
            'humidity' => $this->resource->humidity,
            'visibility' => $this->resource->visibility,
            'windSpeed' => $this->resource->wind_speed,
            'city' => $this->resource->city,
            'country' => $this->resource->country,
            'iconUrl' => $this->resource->icon,
            'dateTime' => $this->resource->datetime->format('l jS \\of F Y'),
        ];
    }
}
