<?php

namespace App\Jobs;

use App\Infrastructure\Services\OpenWeather\OpenWeatherApiClientInterface;
use App\Models\User;
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
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var OpenWeatherApiClientInterface $openWeather */
        $openWeather = resolve(OpenWeatherApiClientInterface::class);

        $user = User::query()->find($this->userId);

        $parameters = new ParameterBag();
        $parameters->set('lat', $user->latitude);
        $parameters->set('lon', $user->longitude);

        $weather = $openWeather->getWeather($parameters);

        if (is_null($weather)) {
            return;
        }

        Weather::query()
            ->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
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
                ]
            );
    }
}
