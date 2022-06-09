<?php

namespace OTIFSolutions\LaravelTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackActivities {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        // logic goes here


        return $next($request);

    }

}