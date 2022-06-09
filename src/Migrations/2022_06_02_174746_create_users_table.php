<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('guest_users', function (Blueprint $table) {
            $table->id();

            // define table structure

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('guest_users');
    }
};