<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('otif_user_request_data', static function (Blueprint $table) {
            $table->engine = 'myIsam';
            $table->id();

            $table->foreignId('user_id')
                ->references('id')
                ->on('otif_users');

            $table->json('request_data');
            $table->string('request_method');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('otif_user_request_data');
    }
};