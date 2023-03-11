<?php

namespace App\Providers;

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
