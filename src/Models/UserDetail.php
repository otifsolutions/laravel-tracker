<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model {

    protected $guarded = [];

    public function userActivities() {
        return $this->hasMany(UserActivity::class);
    }


}
