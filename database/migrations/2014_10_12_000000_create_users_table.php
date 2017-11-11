<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger('id')->unique();
            $table->unsignedBigInteger('sp_id')->nullable();
            $table->text('photo_url')->nullable();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password', 60);
            $table->text('contact_details')->nullable();
            $table->text('social_links')->nullable();
            $table->unsignedTinyInteger('resent')->default(0);
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
