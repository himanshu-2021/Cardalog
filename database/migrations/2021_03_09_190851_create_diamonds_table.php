<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiamondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diamonds', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable()->comment('credit,debit');
            $table->string('diamonds_qty')->nullable()->comment('no. of diamonds');
            $table->string('type')->nullable()->comment('purchase,transfer');
            $table->string('sender_id')->comment('always have user id');
            $table->string('reciever_id')->nullable()->comment('whoever recieve the diamonds');
            $table->string('transection_id')->nullable()->comment('if purchase than generate');
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
        Schema::dropIfExists('diamonds');
    }
}
