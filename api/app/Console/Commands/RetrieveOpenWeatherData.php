<?php

namespace App\Console\Commands;

use App\Infrastructure\Services\OpenWeather\OpenWeatherApiClientInterface;
use App\Models\User;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\HttpFoundation\ParameterBag;

class RetrieveOpenWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'openweather:retrieve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieving current weather from open weather API.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var OpenWeatherApiClientInterface $openWeather */
        $openWeather = resolve(OpenWeatherApiClientInterface::class);

        $users = User::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();


        foreach ($users as $user) {
            $parameters = new ParameterBag();
            $parameters->set('lat', $user->latitude);
            $parameters->set('lon', $user->longitude);

            $dbWeather = Weather::query()
                ->where('user_id', $user->id)
                ->first();

            if (isset($dbWeather) && $dbWeather->updated_at >= Carbon::now()->subMinutes(45)) {
                continue;
            }

            $weather = $openWeather->getWeather($parameters);

            if (is_null($weather)) {
                continue;
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
}
