<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    //
    protected $table='ukuran';
    protected $primaryKey='id_ukuran';
    protected $fillable=['ukuran','size_from_cm','size_to_cm','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
