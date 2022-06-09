<?php

namespace OTIFSolutions\LaravelTracker;

use App\Http\Kernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use OTIFSolutions\LaravelTracker\Commands\RemoveOldData;
use OTIFSolutions\LaravelTracker\Http\Middleware\TrackActivities;

class LaravelTrackerServiceProvider extends ServiceProvider {

    public function boot(Kernel $kernel) {

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $kernel->pushMiddleware(TrackActivities::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                RemoveOldData::class
            ]);
        }

    }

    public function register() {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('remove:old')->daily()->at('08:00');
        });
    }

}