<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class OtifUserActivity extends Model {

    protected $guarded = [];

    public function otifUser() {
        return $this->belongsTo(OtifUser::class);
    }


}