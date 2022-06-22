<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('otif_activity_summaries', static function (Blueprint $table) {
            $table->engine = 'myIsam';
            $table->id();
            $table->string('most_visited_page');
            $table->string('page_hits_per_day');
            $table->string('who_visted_the_page_most');
            $table->string('area_where_the_page_visited_most');
            $table->string('');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('otif_activity_summaries');
    }
};