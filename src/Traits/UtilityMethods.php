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

        $this->trackerStatus = Setting::get('trackerStatus') ?: true;
        $this->trackCookies = Setting::get('trackCookies') ?: true;
        $this->trackMiscData = Setting::get('trackMiscData') ?: false;
        $this->trackHttpRequests = Setting::get('trackHttpRequests') ?: true;
    }

    public function getTrackerStatus(): bool {
        return $this->trackerStatus;
    }

    public function encryptArray(array $array): array {
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

    public function getUserIpAddress() {
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

    public function trackCookies() {
        return $this->trackCookies;
    }

    public function trackHttpRequests() {
        return $this->trackHttpRequests;
    }

    public function trackMiscData() {
        return $this->trackMiscData;
    }

}
