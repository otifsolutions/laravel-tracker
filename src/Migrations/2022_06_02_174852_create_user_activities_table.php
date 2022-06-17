<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {

        if (!Schema::hasTable('user_activities')) {

            Schema::create('user_activities', function (Blueprint $table) {
                $table->id();
                $table->string('client_ip_address');
                $table->string('http_host');
                $table->string('full_url'); // https::example.com/user=34?age=12
                $table->string('redirect_url'); // /show
                $table->string('request_method');   // get
                $table->string('redirect_status');  // 200
                $table->string('query_string')->nullable(); // user=34?age=12
                $table->json('query_string_json')->nullable();
                $table->timestamps();
            });

        }

    }

    public function down() {
        Schema::dropIfExists('user_activities');
    }

};