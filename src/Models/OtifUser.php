<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class OtifUser extends Model {

    protected $guarded = [];

    public function otifUserActivities() {
        return $this->hasMany(OtifUserActivity::class);
    }

}