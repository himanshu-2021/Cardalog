<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_id',100);
            $table->foreignId('user_id',100);
            $table->string('group_name')->nullable();
            $table->string('group_icon')->nullable();
            $table->foreignId('group_creater_user_id')->nullable();
            $table->string('group_delete')->default('0')->comment('0-not delete, 1- delete');
            $table->foreignId('master',100)->nullable()->comment('as a admin');
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
        Schema::dropIfExists('groups');
    }
}
