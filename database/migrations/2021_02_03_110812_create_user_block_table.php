<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_block', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->comment('from user id');
            $table->foreignId('block_user_id');
            $table->longText('reason_for_block')->nullable();
            $table->integer('status')->default(0)->comment('0 unblock 1 is block 2 is admin block');
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
        Schema::dropIfExists('user_block');
    }
}
