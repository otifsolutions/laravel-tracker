<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('user_activities', static function (Blueprint $table) {
            $table->engine = 'myIsam';  // for the insertion and performacne, we are using this engine
            $table->id();

            $table->foreignId('nova_session_id')
                ->references('id')
                ->on('nova_sessions');

            $table->string('full_url'); // https::example.com/user=34?age=12
            $table->string('redirect_url')->nullable(); // /show
            $table->string('request_method');   // get
            $table->string('redirect_status')->nullable();  // 200
            $table->json('query_string_json')->nullable();
            $table->timestamps();

        });
    }

    public function down() {
        Schema::dropIfExists('user_activities');
    }
};