<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class NovaSession extends Model {

    protected $guarded = [];

    public function activities() {
        return $this->hasMany(UserActivity::class, 'nova_session_id', 'id');
    }

    public function requestData() {
        return $this->hasMany(RequestData::class, 'nova_session_id', 'id');
    }

    public function cookies() {
        return $this->hasMany(MyCookie::class, 'nova_session_id', 'id');
    }

}