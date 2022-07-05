<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('my_cookies', static function (Blueprint $table) {
            $table->engine = 'myIsam';
            $table->id();

            $table->foreignId('user_session_id')    // child table colomn name
            ->references('id')
                ->on('user_sessions');    // parent table name

            $table->json('cookies_data');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('my_cookies');
    }

};