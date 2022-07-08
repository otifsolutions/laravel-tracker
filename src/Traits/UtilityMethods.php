<?php

namespace OTIFSolutions\LaravelTracker\Traits;

use Illuminate\Support\Facades\Crypt;
use OTIFSolutions\Laravel\Settings\Models\Setting;

trait UtilityMethods {

    private $trackCookies;
    private $trackHttpRequests;
    private $trackerStatus;
    private $trackMiscData;

    public function __construct() {
        $this->trackerStatus = Setting::get('tracker_status') ?: true;
        $this->trackCookies = Setting::get('track_cookies') ?: false;
        $this->trackMiscData = Setting::get('track_misc_data') ?: false;
        $this->trackHttpRequests = Setting::get('trach_http_requests') ?: true;
    }

    protected function getTrackerStatus(): bool {
        return $this->trackerStatus;
    }

    protected function encryptArray(array $array): array {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = Crypt::encryptString($value);
        }
        return $newArray;
    }

    protected function encryptAssociatveArray(array $array): array {
        $demoArray = [];
        foreach ($array as $key => $value) {
            $demoArray[$key] = Crypt::encryptString($value);
        }
        return $demoArray;
    }

    protected function decryptAssociativeArray(array $array): array {
        $demoArray = [];
        foreach ($array as $key => $value) {
            $demoArray[$key] = Crypt::decryptString($value);
        }
        return $demoArray;
    }

    protected function getUserIpAddress() {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    protected function trackCookies() {
        return $this->trackCookies;
    }

    protected function trackHttpRequests() {
        return $this->trackHttpRequests;
    }

    protected function trackMiscData() {
        return $this->trackMiscData;
    }

}

