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
            $table->string('jenis_pengeluaran');
            $table->integer('jumlah')->unsigned()->nullable();
            $table->float('harga_satuan')->nullable();
            $table->float('total')->nullable();
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
        Schema::dropIfExists('trn_pengeluaran');
    }
}
