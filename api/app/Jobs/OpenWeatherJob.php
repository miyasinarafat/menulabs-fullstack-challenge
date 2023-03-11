<?php

namespace App\Jobs;

use App\Infrastructure\Persistance\WeatherRepositoryInterface;
use App\Infrastructure\Services\OpenWeather\OpenWeatherApiClientInterface;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\ParameterBag;

class OpenWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId,
        public string $latitude,
        public string $longitude,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var OpenWeatherApiClientInterface $openWeather */
        $openWeather = resolve(OpenWeatherApiClientInterface::class);
        /** @var WeatherRepositoryInterface $weatherRepository */
        $weatherRepository = resolve(WeatherRepositoryInterface::class);

        $parameters = new ParameterBag();
        $parameters->set('lat', $this->latitude);
        $parameters->set('lon', $this->longitude);

        $weather = $openWeather->getWeather($parameters);

        if (is_null($weather)) {
            return;
        }

        $candidateWeather = (new Weather())->fill([
            'user_id' => $this->userId,
            'status' => $weather['weather'][0]['main'],
            'description' => $weather['weather'][0]['description'],
            'temperature' => $weather['main']['temp'],
            'temperature_min' => $weather['main']['temp_min'],
            'temperature_max' => $weather['main']['temp_max'],
            'humidity' => $weather['main']['humidity'],
            'visibility' => $weather['visibility'],
            'wind_speed' => $weather['wind']['speed'],
            'city' => empty($weather['name']) ? fake()->city() : $weather['name'],
            'country' => $weather['sys'][0]['country'] ?? fake()->countryCode(),
            'icon' => sprintf(config('weathers.openweather.icon'), $weather['weather'][0]['icon']),
            'datetime' => Carbon::parse($weather['dt'])->toDateTimeString(),
        ]);

        $weatherRepository->update($candidateWeather);
    }
}
