<?php

namespace OTIFSolutions\LaravelTracker\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use OTIFSolutions\LaravelTracker\Models\{MyCookie, UserSession, RequestData, UserActivity, MiscData};
use OTIFSolutions\LaravelTracker\Traits\UtilityMethods;

class TrackActivities {

    use UtilityMethods;

    public function handle(Request $request, Closure $next) {

        if ($this->getTrackerStatus()) {

            $authId = @Auth::user()->id;

            $userSessionObj = UserSession::updateOrCreate(['session_id' => session()->getId()], [
                'auth_id' => $authId,
                'session_id' => $request->session()->getId(),
                'ip_address' => $request->getClientIp(),
                'http_host' => $request->server->get('HTTP_HOST'),
                'http_accept' => $request->server->get('HTTP_ACCEPT'),
                'server_name' => $request->server->get('SERVER_NAME'),
                'server_admin' => $request->server->get('SERVER_ADMIN'),
                'server_addr' => $request->server->get('SERVER_ADDR'),
                'server_signature' => $request->server->get('SERVER_SIGNATURE'),
                'remote_addr' => $request->server->get('REMOTE_ADDR'),
                'browser' => $request->header('User-Agent')
            ]);

            UserActivity::create([
                'user_session_id' => $userSessionObj->id,
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

            if ($this->trackMiscData()) {
                MiscData::create([
                    'user_session_id' => $userSessionObj->id,
                    'http_accept' => $request->server->get('HTTP_ACCEPT'),
                    'http_accept_lang' => $request->server->get('HTTP_ACCEPT_LANGUAGE'),
                    'http_accept_encoding' => $request->server->get('HTTP_ACCEPT_ENCODING'),
                    'http_connection' => $request->server->get('HTTP_CONNECTION'),
                    'http_upgrate_insecure_requests' => $request->server->get('HTTP_UPGRADE_INSECURE_REQUESTS'),
                    'http_sec_fetch_dest' => $request->server->get('HTTP_SEC_FETCH_DEST'),
                    'http_sec_fetch_mode' => $request->server->get('HTTP_SEC_FETCH_MODE'),
                    'http_sec_fetch_site' => $request->server->get('HTTP_SEC_FETCH_SITE'),
                    'http_sec_fetch_user' => $request->server->get('HTTP_SEC_FETCH_USER'),
                    'path' => $request->server->get('PATH'),
                    'document_root' => $request->server->get('DOCUMENT_ROOT'),
                    'request_scheme' => $request->server->get('REQUEST_SCHEME'),
                    'context_prefix' => $request->server->get('CONTEXT_PREFIX'),
                    'context_document_root' => $request->server->get('CONTEXT_DOCUMENT_ROOT'),
                    'script_filename' => $request->server->get('SCRIPT_FILENAME'),
                    'remote_port' => $request->server->get('REMOTE_PORT'),
                    'gateway_interface' => $request->server->get('GATEWAY_INTERFACE'),
                    'server_protocol' => $request->server->get('SERVER_PROTOCOL'),
                    'script_name' => $request->server->get('SCRIPT_NAME'),
                    'php_self' => $request->server->get('PHP_SELF'),
                    'request_time_float' => $request->server->get('REQUEST_TIME_FLOAT'),
                    'request_time' => $request->server->get('REQUEST_TIME')
                ]);
            }

            if ($this->trackHttpRequests()) {
                $encryptRequest = $this->encryptArray($request->all());
                if (!empty($encryptRequest)) {
                    RequestData::create([
                        'user_session_id' => $userSessionObj->id,
                        'request_data' => json_encode($encryptRequest, JSON_THROW_ON_ERROR),
                        'request_method' => $request->server->get('REQUEST_METHOD')
                    ]);
                }
            }

            if ($this->trackCookies()) {
                $encryptedCookies = $this->encryptArray($_COOKIE);
                MyCookie::create([
                    'user_session_id' => $userSessionObj->id,
                    'cookies_data' => json_encode($encryptedCookies, JSON_THROW_ON_ERROR)
                ]);

            }
        }

        return $next($request);
    }

}
