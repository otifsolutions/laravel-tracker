<?php

namespace OTIFSolutions\LaravelTracker\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use OTIFSolutions\Laravel\Settings\Models\Setting;

trait Utilities {

    private $trackCookies;
    private $trackHttpRequests;
    private $trackerStatus;
    private $trackMiscData;

    public function __construct() {
        $this->trackCookies = Setting::get('trackCookies') ?: false;
        $this->trackerStatus = Setting::get('trackerStatus') ?: true;
        $this->trackMiscData = Setting::get('trackMiscData') ?: true;
        $this->trackHttpRequests = Setting::get('trackHttpRequests') ?: true;
    }

    public function getTrackerStatus() {
        return $this->trackerStatus;
    }

    public function encodeRequest(Request $request) {
        $newArray = [];
        foreach ($request->all() as $key => $value) {
            $newArray[$key] = Crypt::encryptString($value);
        }
        return $newArray;
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

    public function getTrackCookies() {
        return $this->trackCookies;
    }

    public function getTrackHttpRequests() {
        return $this->trackHttpRequests;
    }

    public function getTrackMiscData() {
        return $this->trackMiscData;
    }

}

