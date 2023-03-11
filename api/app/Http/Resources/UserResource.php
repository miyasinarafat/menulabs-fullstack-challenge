<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Weather;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read User $resource
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $weather = Weather::query()->where('user_id', $this->resource->id)->first();

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'latitude' => $this->resource->latitude,
            'longitude' => $this->resource->longitude,
            'weather' => $weather !== null
                ? WeatherResource::make($weather)
                : null
        ];
    }
}
