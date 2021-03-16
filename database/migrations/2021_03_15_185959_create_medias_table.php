<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id',100);
            $table->string('group_id',100);
            $table->string('name')->nullable();
            $table->string('file_type')->comment('0-image, 1- video')->nullable();
            $table->string('chat_type')->comment('personal,group')->nullable();
            $table->integer('sender_id')->comment('who send the video')->nullable();
            $table->integer('reciever')->comment('which recieve a video')->nullable();
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('medias');
    }
}
