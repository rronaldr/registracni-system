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
            $table->integer('calendar_id')->nullable();
            $table->string('contact_person');
            $table->string('contact_email');
            $table->integer('type');
            $table->integer('status');
            $table->json('c_fields')->nullable();
            $table->text('template_content')->nullable();
            $table->boolean('global_blacklist')->default(false);
            $table->boolean('event_blacklist')->default(false);
            $table->integer('user_group');
            $table->dateTime('date_start_cache')->nullable();
            $table->dateTime('date_end_cache')->nullable();
            $table->integer('last_changed_by')->nullable();
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
