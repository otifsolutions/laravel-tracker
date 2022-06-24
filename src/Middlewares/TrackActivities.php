<?php

namespace OTIFSolutions\LaravelTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTIFSolutions\LaravelTracker\Models\OtifUser;
use OTIFSolutions\LaravelTracker\Models\OtifUserActivity;
use OTIFSolutions\LaravelTracker\Traits\Utilities;

class TrackActivities {

    use Utilities;

    public function handle(Request $request, Closure $next) {

        if ($this->trackerStatus) {

            if (!OtifUser::where('ip_address', $request->getClientIp())->exists()) {
                OtifUser::create([
                    'name' => Auth::user()->name ?? null,
                    'email' => Auth::user()->email ?? null,
                    'session_id' => $request->session()->getId(),
                    'ip_address' => $request->getClientIp(),
                    'http_host' => $request->server->get('HTTP_HOST'),
                    'browser' => $request->header('User-Agent')
                ]);
            }

            OtifUserActivity::create([
                'user_id' => OtifUser::where('ip_address', $request->getClientIp())->first()['id'],
                'session_id' => $request->session()->getId(),
                'full_url' => $request->fullUrl(),
                'redirect_url' => $request->server->get('REDIRECT_URL'),
                'request_method' => $request->server->get('REQUEST_METHOD'),
                'redirect_status' => $request->server->get('REDIRECT_STATUS'),
                'query_string' => $request->server->get('QUERY_STRING'),
                'query_string_json' => json_encode(explode('?', $request->server->get('QUERY_STRING')), JSON_THROW_ON_ERROR)
            ]);

        }

        return $next($request);
    }

    // register your own facade methods and use them into your code plz

}
