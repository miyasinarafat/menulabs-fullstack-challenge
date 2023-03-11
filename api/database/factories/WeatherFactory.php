<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Weather::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->id,
            'status' => $this->faker->randomElement(['Sunny', 'Cloudy', 'Rainy', 'Snowy']),
            'description' => $this->faker->paragraph(1),
            'temperature' => $this->faker->randomFloat(2, -120, 120),
            'temperature_min' => $this->faker->randomFloat(2, -120, 0),
            'temperature_max' => $this->faker->randomFloat(2, 0, 120),
            'humidity' => $this->faker->randomNumber(2),
            'visibility' => $this->faker->randomNumber(2),
            'wind_speed' => $this->faker->randomNumber(2),
            'city' => $this->faker->city(),
            'country' => $this->faker->countryCode(),
            'icon' => $this->faker->randomNumber(),
            'datetime' => $this->faker->dateTime(),
        ];
    }
}
