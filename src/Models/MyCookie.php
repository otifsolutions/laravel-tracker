<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class MyCookie extends Model {

    protected $guarded = [];

    // accessor "cookies_data" colomn
    protected function getCookiesDataAttribute($value) {
        $newArray = [];
        foreach (json_decode($value) as $key => $item) {
            $newArray[$key] = Crypt::decryptString($item);
        }
        return $newArray;
    }

    public function cookies() {
        return $this->belongsTo(NovaSession::class);
    }

}
