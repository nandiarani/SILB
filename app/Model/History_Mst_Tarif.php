<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class History_Mst_Tarif extends Model
{
    protected $table='history_mst_tarif';
    protected $primaryKey='id_ukuran';
    protected $fillable=['size_from_cm','size_to_cm','harga_per_ekor','added_at','added_by','updated_at','updated_by'];
    public $timestamps=false;
}
