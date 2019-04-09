<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrnPengeluaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trn_pengeluaran', function (Blueprint $table) {
            $table->increments('id_pengeluaran');
            $table->unsignedInteger('id_jenis_pengeluaran');
            $table->foreign('id_jenis_pengeluaran')->references('id_jenis_pengeluaran')->on('jenis_pengeluaran')->onDelete('cascade');
            $table->integer('jumlah')->unsigned()->nullable();
            $table->float('harga_satuan')->nullable();
            $table->float('total')->nullable();

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
        Schema::dropIfExists('trn_pengeluaran');
    }
}
