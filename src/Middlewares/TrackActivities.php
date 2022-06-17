<?php

namespace OTIFSolutions\LaravelTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JsonException;
use OTIFSolutions\LaravelTracker\Models\UserActivity;

class TrackActivities {

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws JsonException
     */
    public function handle($request, Closure $next) {

        // logic goes here

        // track every single activity
        UserActivity::create([
            'client_ip_address' => $request->getClientIp(),
            'http_host' => $request->server->get('HTTP_HOST'),
            'full_url' => $request->fullUrl(),
            'redirect_url' => $request->server->get('REDIRECT_URL'),
            'request_method' => $request->server->get('REQUEST_METHOD'),
            'redirect_status' => $request->server->get('REDIRECT_STATUS'),
            'query_string' => $request->server->get('QUERY_STRING'),
            'query_string_json' => json_encode(explode('?', $request->server->get('QUERY_STRING')), JSON_THROW_ON_ERROR)
        ]);

        return $next($request);

    }

}