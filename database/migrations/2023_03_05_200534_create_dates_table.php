<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->string('location');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->dateTime('enrollment_from');
            $table->dateTime('enrollment_to');
            $table->dateTime('withdraw_to');
            $table->integer('capacity');
            $table->string('name')->nullable();
            $table->boolean('substitute');
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
        Schema::dropIfExists('dates');
    }
}
