<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class MyCookie extends Model {

    protected $guarded = [];

    public function cookies() {
        return $this->belongsTo(NovaSession::class);      // define relationship with session
    }

}


