<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('otif_users', static function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // if authed, get his name from actual users table and put that here
            $table->string('email')->nullable();    // if user authed, get his email from users table and put that here
            $table->string('session_id');   // it will never be nullable
            $table->string('ip_address');
            $table->string('http_host');
            $table->string('browser')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('otif_users');
    }
};