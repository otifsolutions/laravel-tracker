<?php

namespace OTIFSolutions\LaravelTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTIFSolutions\LaravelTracker\Models\OtifUser;
use OTIFSolutions\LaravelTracker\Models\OtifUserActivity;
use OTIFSolutions\LaravelTracker\Models\OtifUserRequestData;
use OTIFSolutions\LaravelTracker\Traits\Utilities;

class TrackActivities {

    use Utilities;

    public function handle(Request $request, Closure $next) {

        if ($this->getTrackerStatus()) {

            if (!OtifUser::where('ip_address', $request->getClientIp())->exists()) {

                if (!Auth::check()) {
                    OtifUser::create([
                        'name' => null,
                        'email' => null,
                        'session_id' => $request->session()->getId(),
                        'ip_address' => $request->getClientIp(),
                        'http_host' => $request->server->get('HTTP_HOST'),
                        'browser' => $request->header('User-Agent')
                    ]);
                }
            }

            // if same guest is authed, new session is generated
            if (Auth::check()) {
                OtifUser::updateOrCreate(['name' => Auth::user()->name, 'email' => Auth::user()->email], [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'session_id' => $request->session()->getId(),
                    'ip_address' => $request->getClientIp(),
                    'http_host' => $request->server->get('HTTP_HOST'),
                    'browser' => $request->header('User-Agent')
                ]);
            }

            $userId = OtifUser::where('ip_address', $request->getClientIp())->latest()->first()->id;

            OtifUserActivity::create([
                'user_id' => $userId,
                'full_url' => $request->fullUrl(),
                'redirect_url' => $request->server->get('REDIRECT_URL'),
                'request_method' => $request->server->get('REQUEST_METHOD'),
                'redirect_status' => $request->server->get('REDIRECT_STATUS'),
                'query_string_json' => json_encode(explode('?', $request->server->get('QUERY_STRING')), JSON_THROW_ON_ERROR)
            ]);

            if (!empty($this->encodeRequest($request)) && Auth::check()) {
                OtifUserRequestData::create([
                    'user_id' => $userId,
                    'request_data' => json_encode($this->encodeRequest($request), JSON_THROW_ON_ERROR),
                    'request_method' => $request->server->get('REQUEST_METHOD')
                ]);
            }
        }

        return $next($request);
    }

    // register your own facade methods and use them into your code plz

}
