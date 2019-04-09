<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modal', function (Blueprint $table) {
            $table->increments('id_modal');
            $table->float('nominal')->nullable();

            $table->dateTime('added_at')->nullable();
            $table->integer('added_by')->unsigned()->nullable();
            $table->foreign('added_by')->references('id_user')->on('users');
            
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id_user')->on('users');
            
            $table->boolean('flag_active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modal');
    }
}
