<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// TODO : THE PARENT TABLE OF ALL THE PACKAGE TABLES
// THE PARENT TABLE FOR ALL THE TABLES NOW, NAME CHANGED FROM OTIFUSER TO MYSESSION

class NovaSession extends Model {

    // for the mass assignment, nothing will be guarded
    protected $guarded = [];


    // TODO : ADD KEYS HERE
    // relation with activities, table, the new model name will be UserActivity
    public function activities() {
        return $this->hasMany(UserActivity::class, 'nova_session_id', 'id');
    }

    // TODO : ADD KEYS HERE
    public function requestData() {
        return $this->hasMany(RequestData::class, 'nova_session_id', 'id');
    }


    public function cookies() {
        return $this->hasMany(MyCookie::class, 'nova_session_id', 'id');
    }





}