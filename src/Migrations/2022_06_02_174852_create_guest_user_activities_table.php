<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('guest_user_activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            //

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('guest_user_activities');
    }
};