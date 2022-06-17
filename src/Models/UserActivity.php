<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model {

    protected $guarded = [];

    public function userDetail() {
        return $this->belongsTo(UserDetail::class);
    }

}