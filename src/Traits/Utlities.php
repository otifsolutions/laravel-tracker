<?php

namespace OTIFSolutions\LaravelTracker\Traits;

use OTIFSolutions\Laravel\Settings\Models\Setting;

trait Utlities {

    private bool $trackCookies;
    private bool $trackHttpRequests;
    private $trackerStatus;
    private bool $trackMiscData;

    public function __construct() {

        $this->trackCookies = false;
        $this->trackerStatus = Setting::get('trackerStatus') ?: true;
        $this->trackMiscData = false;
        $this->trackHttpRequests = false;

    }


    public function getTrackerStatus() {
        return $this->trackerStatus;
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

}

