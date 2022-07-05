<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('user_sessions', static function (Blueprint $table) {
            $table->engine = 'myIsam';
            $table->id();
            $table->unsignedInteger('auth_id')->nullable();
            $table->string('session_id');   // the actual session id, it is a random string
            $table->string('ip_address');
            $table->string('http_host');
            $table->string('http_accept');
            $table->string('http_accept_encoding');
            $table->string('server_name');
            $table->string('server_addr');
            $table->string('remote_addr');
            $table->string('server_admin');
            $table->string('server_signature');
            $table->string('browser')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('my_sessions');
    }
};