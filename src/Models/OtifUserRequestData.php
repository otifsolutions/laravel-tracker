<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class OtifUserRequestData extends Model {

    protected $guarded = [];

    public function getRequestDataAttribute($value) {
        $newArray = [];
        foreach (json_decode($value) as $key => $item) {
            $newArray[$key] = Crypt::decryptString($item);
        }
        return $newArray;
    }

    public function otifUser() {
        return $this->belongsTo(OtifUser::class);
    }

}