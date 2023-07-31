<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blacklist_id')->nullable();
            $table->foreignId('template_id');
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('type');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->json('c_fields')->nullable();
            $table->string('template_subject')->nullable();
            $table->text('template_content')->nullable();
            $table->dateTime('date_start_cache')->nullable();
            $table->dateTime('date_end_cache')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
