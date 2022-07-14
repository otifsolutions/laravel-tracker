<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->engine = 'myIsam';
            $table->id();
            $table->unsignedInteger('auth_id')->nullable();
            $table->string('session_id');   // the actual sesssion_id, the random string
            $table->string('ip_address');
            $table->string('http_host');
            $table->string('http_accept');
            $table->string('server_name')->nullable();
            $table->string('server_admin')->nullable();
            $table->string('server_addr')->nullable();
            $table->string('server_signature')->nullable();
            $table->string('remote_addr');
            $table->string('browser')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('my_sessions');
    }
};