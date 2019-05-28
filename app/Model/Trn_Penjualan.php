<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Trn_Penjualan extends Model
{
    //
    
    protected $table='trn_penjualan';
    protected $fillable=['id_penjualan','tahap','id_ukuran','penjualan_ke','jumlah_ikan','harga_per_ekor','total','added_at','added_by','updated_at','updated_by','flag_active'];
}
