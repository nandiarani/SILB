<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryMstTarif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_mst_tarif', function (Blueprint $table) {
            $table->increments('id_ukuran');
            $table->string('ukuran')->nullable();
            $table->integer('size_from_cm')->unsigned()->nullable();
            $table->integer('size_to_cm')->unsigned()->nullable();
            $table->float('harga_per_ekor')->nullable();
            

            $table->dateTime('added_at')->nullable();
            $table->integer('added_by')->nullable();
            
            $table->dateTime('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_mst_tarif');
    }
}
