<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mst_Harga_Ikan extends Model
{
    //
    protected $table='mst_harga_ikan';
    protected $primaryKey='id_ukuran';
    protected $fillable=['size_from_cm','size_to_cm','harga_per_ekor','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
