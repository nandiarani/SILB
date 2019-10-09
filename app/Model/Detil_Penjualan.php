<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detil_Penjualan extends Model
{
    protected $table ='detil_penjualan';
    protected $primaryKey='id_detil_penjualan';
    protected $fillable=['id_penjualan','id_ukuran','jumlah_ikan','subtotal','flag_active'];
    public $timestamps=false;
}
