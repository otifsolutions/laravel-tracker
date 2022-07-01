<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

// if user is authed, and enabled from package settings, then this will run and track requests


class RequestData extends Model {

    protected $guarded = [];


    // accessor for the "request_data"
    public function getRequestDataAttribute($value) {
        $newArray = [];
        foreach (json_decode($value) as $key => $item) {
            $newArray[$key] = Crypt::decryptString($item);
        }
        return $newArray;
    }



    public function novaSession() {
        return $this->belongsTo(NovaSession::class);
    }








}