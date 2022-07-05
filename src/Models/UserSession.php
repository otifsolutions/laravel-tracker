<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model {

    protected $guarded = [];

    public function userActivities() {
        return $this->hasMany(UserActivity::class);
    }

    public function requestData() {
        return $this->hasMany(RequestData::class, 'user_session_id', 'id');
    }

    public function cookiesData() {
        return $this->hasMany(MyCookie::class, 'user_session_id', 'id');
    }

}