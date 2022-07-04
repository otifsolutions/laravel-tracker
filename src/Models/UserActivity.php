<?php

namespace OTIFSolutions\LaravelTracker\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model {

    protected $guarded = [];

    public function novaSession() {
        return $this->belongsTo(NovaSession::class, 'nova_session_id');
    }

}