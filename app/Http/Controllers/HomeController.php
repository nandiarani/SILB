<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Trn_Penjualan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getDataPenjualan(){
        $data=DB::table('trn_penjualan')
        ->select(DB::raw("sum(jumlah_ikan) as jumlah_ikan, tanggal"))
        ->where('flag_active','=','1')
        ->groupby('tanggal')
        ->orderby('tanggal','asc')                
        ->get();
        // $data=DB::select(DB::raw("select sum(jumlah_ikan) as total, MONTH(tanggal) as month, year(tanggal) as year FROM trn_penjualan group BY Month(tanggal),year(tanggal) order by year(tanggal) asc,month(tanggal) asc"));
        return ($data);
    }
}
