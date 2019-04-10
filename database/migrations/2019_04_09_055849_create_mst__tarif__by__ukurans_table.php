<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstTarifByUkuransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_tarif_by_ukuran', function (Blueprint $table) {
            $table->increments('id_ukuran');
            $table->string('ukuran')->nullable();
            $table->integer('size_from_cm')->unsigned()->nullable();
            $table->integer('size_to_cm')->unsigned()->nullable();
            $table->float('harga_per_ekor')->nullable();

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
        Schema::dropIfExists('mst_tarif_by_ukuran');
    }
}