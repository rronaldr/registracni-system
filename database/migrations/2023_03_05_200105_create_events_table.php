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
            $table->integer('type');
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->json('c_fields')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('hidden')->default(false);
            $table->dateTime('hidden_at')->nullable();
            $table->longText('template_content')->nullable();
            $table->text('dates_cache')->nullable();
            $table->string('subject')->nullable();
            $table->timestamps();
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
