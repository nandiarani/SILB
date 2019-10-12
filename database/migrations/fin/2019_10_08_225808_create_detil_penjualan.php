<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detil_penjualan', function (Blueprint $table) {
            $table->increments('id_detil_penjualan');
            $table->integer('id_penjualan')->unsigned();
            $table->integer('id_ukuran')->unsigned();
            $table->integer('jumlah_ikan')->unsigned();
            $table->float('subtotal',20,2)->unsigned();
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
        Schema::dropIfExists('detil_penjualan');
    }
}
