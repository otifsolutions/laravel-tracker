<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model {

    protected $guarded = [];

    public function userSession() {
        return $this->belongsTo(UserSession::class, 'user_session_id');
    }

}