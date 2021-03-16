<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('avatar',256)->nullable();
            $table->string('name',50)->nullable();
            $table->string('social_type')->comment('apple,facebook,kakoatolk,email')->nullable();
            $table->string('nick_name',50)->unique()->nullable();
            $table->string('phone_code',10)->nullable();
            $table->string('mobile',15)->unique()->nullable();
            $table->string('country')->nullable();
            $table->string('gender',7)->nullable();
            $table->date('dob')->nullable();
            $table->string('email',100)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('package_id');
            $table->string('terms_conditions',2)->default(0)->comment('1 is accept 0 is not accept');
            $table->string('privacy_policy',2)->default(0)->comment('1 is accept 0 is not accept');
            $table->string('location_service_policy',2)->default(0)->comment('1 is accept 0 is not accept');
            $table->string('device_id')->nullable();
            $table->longText('contact_details',256)->nullable();
            $table->integer('role')->default(0)->comment('0 is user 1 is admin');
            $table->integer('account_status')->default(1)->comment('1 active 0 is suspend');
            $table->integer('login_status')->default(0)->comment('1 is login 0 is not login');
            $table->integer('is_deleted')->default(0)->comment('1 is delete 0 is not delete');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
