<?php

return [
    'openweather' => [
        'api_key' => env('OPEN_WEATHER_API_KEY'),
        'base_url' => 'https://api.openweathermap.org/data/2.5',
        'current_weather' => '/weather',
        'icon' => 'https://openweathermap.org/img/wn/%s@2x.png',
    ],
];
