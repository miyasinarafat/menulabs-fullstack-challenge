<?php

namespace App\Console\Commands;

use App\Infrastructure\Persistance\UserRepositoryInterface;
use App\Jobs\OpenWeatherJob;
use App\Models\User;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

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
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = resolve(UserRepositoryInterface::class);

        $weatherJobs = [];
        /** @var User $user */
        foreach ($userRepository->getList() as $user) {
            $dbWeather = Weather::query()
                ->where('user_id', $user->id)
                ->first();

            if (isset($dbWeather) && $dbWeather->updated_at >= Carbon::now()->subMinutes(45)) {
                continue;
            }

            $weatherJobs[] = new OpenWeatherJob($user->id, $user->latitude, $user->longitude);
        }

        Bus::batch($weatherJobs)
            ->name('RetrieveOpenWeatherData::weathers-batch-jobs')
            ->allowFailures()
            ->dispatch();
    }
}
