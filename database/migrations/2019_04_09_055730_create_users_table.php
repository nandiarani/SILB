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
            $table->increments('id_user');
            $table->string('nama');
            $table->string('username',20)->unique();
            $table->string('email',254)->unique();
            $table->string('password');
            $table->unsignedInteger('id_peran');
            $table->foreign('id_peran')->references('id_peran')->on('peran')->onDelete('cascade');
            $table->boolean('flag_active')->nullable()->default(false);
            $table->timestamp('email_verified_at')->nullable();
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
