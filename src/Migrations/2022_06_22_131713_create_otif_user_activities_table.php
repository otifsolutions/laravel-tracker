<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('otif_user_activities', static function (Blueprint $table) {
            $table->engine = 'myIsam';
            $table->id();
            $table->foreignId('user_id')
                ->references('id')
                ->on('otif_users');
            $table->string('session_id');
            $table->string('full_url'); // https::example.com/user=34?age=12
            $table->string('redirect_url'); // /show
            $table->string('request_method');   // get
            $table->string('redirect_status');  // 200
            $table->string('query_string')->nullable(); // user=34?age=12
            $table->json('query_string_json')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('otif_user_activities');
    }
};