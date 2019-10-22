<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detil_Penjualan extends Model
{
    protected $table ='detil_penjualan';
    protected $primaryKey='id_detil_penjualan';
    protected $fillable=['id_penjualan','id_harga','jumlah_ikan','subtotal','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
