<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Jenis_Pengeluaran extends Model
{
    protected $table ='jenis_pengeluaran';
    protected $primaryKey='id_jenis_pengeluaran';
    protected $fillable=['jenis_pengeluaran','added_at','added_by','updated_at','updated_by','flag_active'];
}
