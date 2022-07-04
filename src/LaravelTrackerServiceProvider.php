<?php

namespace OTIFSolutions\LaravelTracker;

use Closure;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use OTIFSolutions\LaravelTracker\Commands\DeleteRecordsBeforeCertainDays;
use OTIFSolutions\LaravelTracker\Http\Middleware\TrackActivities;

class LaravelTrackerServiceProvider extends ServiceProvider {

    public function booted(Closure $callback) {
        $schedule = $this->app->make(Schedule::class);
        $schedule->command('clear:records')->daily()->at('08:00');
    }

    public function boot(Kernel $kernel) {

        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');
        $kernel->pushMiddleware(TrackActivities::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                DeleteRecordsBeforeCertainDays::class
            ]);
        }

    }

}