<?php

namespace App\Providers;

use App\Infrastructure\Persistance\UserRepository;
use App\Infrastructure\Persistance\UserRepositoryInterface;
use App\Infrastructure\Persistance\WeatherRepository;
use App\Infrastructure\Persistance\WeatherRepositoryInterface;
use App\Infrastructure\Services\OpenWeather\OpenWeatherApiClient;
use App\Infrastructure\Services\OpenWeather\OpenWeatherApiClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OpenWeatherApiClientInterface::class, OpenWeatherApiClient::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(WeatherRepositoryInterface::class, WeatherRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
