<?php

namespace OTIFSolutions\LaravelTracker;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use OTIFSolutions\LaravelTracker\Commands\RemoveOldData;

class LaravelTrackerServiceProvider extends ServiceProvider {

    public function boot() {

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

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