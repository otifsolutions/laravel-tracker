<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {

        Schema::create('misc_data', static function (Blueprint $table) {
            $table->engine = 'myIsam';  // for performance and fast data insertion
            $table->id();

            // RELATIONSHIP
            $table->foreignId('user_session_id')
                ->references('id')
                ->on('user_sessions');

            // COLOMNS
            $table->string('http_accept')->nullable();
            $table->string('http_accept_lang')->nullable();
            $table->string('http_accept_encoding')->nullable();
            $table->string('http_connection')->nullable();
            $table->string('http_upgrate_insecure_requests')->nullable();
            $table->string('http_sec_fetch_dest')->nullable();
            $table->string('http_sec_fetch_mode')->nullable();
            $table->string('http_sec_fetch_site')->nullable();
            $table->string('http_sec_fetch_user')->nullable();
            $table->string('path')->nullable();
            $table->string('document_root')->nullable();
            $table->string('request_scheme')->nullable();
            $table->string('context_prefix')->nullable();
            $table->string('context_document_root')->nullable();
            $table->string('script_filename')->nullable();
            $table->string('remote_port')->nullable();
            $table->string('gateway_interface')->nullable();
            $table->string('server_protocol')->nullable();
            $table->string('script_name')->nullable();
            $table->string('php_self')->nullable();
            $table->unsignedDouble('request_time_float')->nullable();
            $table->unsignedDouble('request_time')->nullable();

            // TIMESTAMPS
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('misc_data');
    }

};