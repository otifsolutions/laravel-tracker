<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class MiscData extends Model {

    protected $guarded = [];

    public function userSession() {
        return $this->belongsTo(UserSession::class, 'user_session_id', 'id');
    }

}