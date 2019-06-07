<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    protected $table='modal';
    protected $primaryKey='id_modal';
    protected $fillable=['nominal','tanggal','added_at','added_by','updated_at','updated_by','flag_active'];
    public $timestamps=false;
}
