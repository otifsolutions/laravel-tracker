<?php

namespace OTIFSolutions\LaravelTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use OTIFSolutions\LaravelTracker\Models\{NovaSession, RequestData, UserActivity};
use OTIFSolutions\LaravelTracker\Traits\Utilities;

class TrackActivities {

    use Utilities;

    public function handle(Request $request, Closure $next) {

        if ($this->getTrackerStatus()) {

            $authId = @Auth::user()->id;

            $novaObj = NovaSession::updateOrCreate(['session_id' => $request->session()->getId()], [
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

            UserActivity::create([
                'nova_session_id' => $novaObj->id,
                'full_url' => $request->fullUrl(),
                'redirect_url' => $request->server->get('REDIRECT_URL'),
                'request_method' => $request->server->get('REQUEST_METHOD'),
                'redirect_status' => $request->server->get('REDIRECT_STATUS'),
                'query_string_json' => json_encode(
                    explode(
                        '?',
                        $request->server->get('QUERY_STRING')
                    ),
                    JSON_THROW_ON_ERROR
                )
            ]);

            if ($this->trackHttpRequests()) {

                $encryptRequest = $this->encryptArray($request->all());

                if (!empty($encryptRequest)) {
                    RequestData::create([
                        'nova_session_id' => $novaObj->id,
                        'request_data' => json_encode($encryptRequest, JSON_THROW_ON_ERROR),
                        'request_method' => $request->server->get('REQUEST_METHOD')
                    ]);
                }
            }

            if ($this->trackCookies() && empty(array_diff($_COOKIE, MyCookie::latest()->first()->cookies_data))) {
                $encryptedCookies = $this->encryptArray($_COOKIE);
                MyCookie::create([
                    'nova_session_id' => $novaObj->id,
                    'cookies_data' => json_encode($encryptedCookies, JSON_THROW_ON_ERROR)
                ]);
            }
        }

        return $next($request);
    }

}
