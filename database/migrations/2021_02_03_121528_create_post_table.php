<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id');
            $table->string('title',100);
            $table->string('conversation',10)->comment('whoever,male,female');
            $table->string('billing_per_minute',15)->comment('take it ,I give you');
            $table->integer('pieces')->comment('no of pieces');
            $table->string('file')->comment('video or images');
            $table->integer('file_type')->comment('1 is video or 0 is image');
            $table->string('status')->default('1')->comment('1 is show 0 is not show');
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
        Schema::dropIfExists('post');
    }
}
