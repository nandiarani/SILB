<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Trn_Penjualan extends Model
{
    protected $table='trn_penjualan';
    protected $primaryKey='id_penjualan';
    protected $fillable=['tahap','ukuran','penjualan_ke','jumlah_ikan','harga_per_ekor','size_from_cm','size_to_cm','total','tanggal','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
