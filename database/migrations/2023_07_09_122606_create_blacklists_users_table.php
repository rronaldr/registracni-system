<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlacklistsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blacklists_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blacklist_id');
            $table->foreignId('user_id');
            $table->string('block_reason')->nullable();
            $table->dateTime('blocked_until')->nullable();
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
        Schema::dropIfExists('blacklists_users');
    }
}
