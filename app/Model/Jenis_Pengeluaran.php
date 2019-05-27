<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Jenis_Pengeluaran extends Model
{
    protected $table ='jenis_pengeluaran';
    protected $fillable=['id_jenis_pengeluaran','jenis_pengeluaran','flag_active','created_at','updated_at'];

    public function trn_pengeluaran()
    {
        return $this->hasMany(trn_pengeluaran, 'id_jenis_pengeluaran', 'id_jenis_pengeluaran');
    }
}
