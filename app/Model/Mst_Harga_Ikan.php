<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mst_Harga_Ikan extends Model
{
    //
    protected $table='mst_harga_ikan';
    protected $primaryKey='id_harga';
    protected $fillable=['id_ukuran','harga_per_ekor','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
