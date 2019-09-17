<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstHargaIkansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_harga_ikan', function (Blueprint $table) {
            $table->increments('id_ukuran');
            $table->string('ukuran')->nullable();
            $table->integer('size_from_cm')->unsigned()->nullable();
            $table->integer('size_to_cm')->unsigned()->nullable();
            $table->float('harga_per_ekor',20,2)->nullable();
            $table->date('added_at')->nullable();
            $table->integer('added_by')->nullable();            
            $table->date('updated_at')->nullable();
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
        Schema::dropIfExists('mst_harga_ikan');
    }
}
