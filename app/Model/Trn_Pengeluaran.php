<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Trn_Pengeluaran extends Model
{
    protected $table='trn_pengeluaran';
    protected $primaryKey='id_pengeluaran';
    protected $fillable=['id_jenis_pengeluaran','jumlah','harga_satuan','total','tanggal','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
