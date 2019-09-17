<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Trn_Penjualan extends Model
{
    protected $table='trn_penjualan';
    protected $primaryKey='id_penjualan';
    protected $fillable=['tahap','penjualan_ke','jumlah_ikan','id_ukuran','total','tanggal','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
