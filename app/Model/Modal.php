<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    //
    
    protected $table='modal';
    protected $fillable=['id_modal','nominal','added_at','added_by','updated_at','updated_by','flag_active'];
}
