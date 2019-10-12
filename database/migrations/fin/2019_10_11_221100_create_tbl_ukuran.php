<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUkuran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukuran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_ukuran');
            $table->integer('size_from_cm')->unsigned();
            $table->integer('size_to_cm')->unsigned();
            
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
        Schema::dropIfExists('ukuran');
    }
}
