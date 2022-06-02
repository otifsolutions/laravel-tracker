<?php

namespace OTIFSolutions\LaravelTracker;

use Closure;
use Illuminate\Support\ServiceProvider;

class LaravelTrackerServiceProvider extends ServiceProvider {

    public function register() {

    }

    public function booted(Closure $callback) {
        $this->loadMigrationsFrom(__DIR__ );
    }
}