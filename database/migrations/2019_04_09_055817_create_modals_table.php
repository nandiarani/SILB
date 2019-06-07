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
            $table->dateTime('tanggal')->nullable();

            $table->dateTime('added_at')->nullable();
            $table->integer('added_by')->nullable();
            
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->enum('flag_active', ['0', '1']);
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
