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
            $table->integer('capacity');
            $table->dateTime('enrollment_start')->nullable();
            $table->dateTime('enrollment_end')->nullable();
            $table->dateTime('withdraw_end')->nullable();
            $table->string('name')->nullable();
            $table->boolean('substitute')->default(false);
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
        Schema::dropIfExists('dates');
    }
}
