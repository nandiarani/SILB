<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mst_Tarif_By_Ukuran extends Model
{
    protected $table='mst_tarif_by_ukuran';
    protected $primaryKey='id_ukuran';
    protected $fillable=['size_from_cm','size_to_cm','harga_per_ekor','added_at','added_by','updated_at','updated_by','flag_active'];
}
