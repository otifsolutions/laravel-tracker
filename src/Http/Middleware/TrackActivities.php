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

            $authId = @Auth::user()->id;

            NovaSession::updateOrCreate(['session_id' => $request->session()->getId()], [
                'auth_id' => $authId,
                'session_id' => $request->session()->getId(),
                'ip_address' => $request->getClientIp(),
                'http_host' => $request->server->get('HTTP_HOST'),
                'http_accept' => $request->server->get('HTTP_ACCEPT'),
                'http_accept_encoding' => $request->server->get('HTTP_ACCEPT_ENCODING'),
                'server_name' => $request->server->get('SERVER_NAME'),
                'server_addr' => $request->server->get('SERVER_ADDR'),
                'remote_addr' => $request->server->get('REMOTE_ADDR'),
                'server_admin' => $request->server->get('SERVER_ADMIN'),
                'server_signature' => $request->server->get('SERVER_SIGNATURE'),
                'browser' => $request->header('User-Agent')
            ]);


            $userId = OtifUser::where('ip_address', $request->getClientIp())->latest()->first()->id;

            OtifUserActivity::create([
                'user_id' => $userId,
                'full_url' => $request->fullUrl(),
                'redirect_url' => $request->server->get('REDIRECT_URL'),
                'request_method' => $request->server->get('REQUEST_METHOD'),
                'redirect_status' => $request->server->get('REDIRECT_STATUS'),
                'query_string_json' => json_encode(explode('?', $request->server->get('QUERY_STRING')), JSON_THROW_ON_ERROR)
            ]);

            if ($this->trackHttpRequests()) {
                $encodedRequest = $this->encodeRequest($request);
                if (!empty($encodedRequest) && Auth::check()) {
                    OtifUserRequestData::create([
                        'user_id' => $userId,
                        'request_data' => json_encode($encodedRequest, JSON_THROW_ON_ERROR),
                        'request_method' => $request->server->get('REQUEST_METHOD')
                    ]);
                }
            }
        }

        return $next($request);
    }

    // register your own facade methods and use them into your code plz

}
