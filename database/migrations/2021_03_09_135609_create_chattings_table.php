<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChattingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chattings', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id',100);
            $table->integer('media_id')->comment('id of the upload file')->nullable();
            $table->foreignId('from_user_id')->comment('id from the users table');
            $table->integer('to');
            $table->string('message')->nullable();
            $table->integer('leave')->nullable()->default(0)->comment('0-part,1-leave');
            $table->integer('is_block')->nullable()->default(0)->comment('0-not block,1-blocked');
            $table->string('chat_type',100)->comment('group,personal');
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('chattings');
    }
}
