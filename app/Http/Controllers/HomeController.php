<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Model\Trn_Penjualan;
use Illuminate\Support\Facades\DB;
use Log;

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
        $dropdownmonth=DB::select("select month(tanggal) as mon, monthname(tanggal) as month from trn_penjualan union DISTINCT select month(tanggal) as mon, monthname(tanggal) as month from trn_pengeluaran order by mon");
        $dropdownyear=DB::select("select year(tanggal) as year from trn_penjualan union DISTINCT select year(tanggal) as year from trn_pengeluaran order by year");
        return view('home',compact('dropdownmonth','dropdownyear'));
    }
    function fetchChart($month,$year){
        
        
        Log::info($month);
        
        if ($month==0) {
            $penjualan=DB::table('trn_penjualan')
                    ->select(DB::raw('concat("1 ",date_format(tanggal,"%M %Y")) as period, sum(total) as penjualan , 0 as pengeluaran'))
                    ->whereraw('flag_active="1" and year(tanggal)=?',$year)
                    ->groupBy(DB::raw('period'))
                    ->orderBy('tanggal','ASC')
                    ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
                    ->select(DB::raw('concat("1 ",date_format(tanggal,"%M %Y")) as period, sum(total) as pengeluaran , 0 as penjualan'))
                    ->whereraw('flag_active="1" and year(tanggal)=?',$year)
                    ->groupBy(DB::raw('period'))
                    ->orderBy('tanggal','ASC')
                    ->get();
        } else {
            $penjualan=DB::table('trn_penjualan')
                    ->select(DB::raw('tanggal as period, sum(total) as penjualan , 0 as pengeluaran'))
                    ->whereraw('flag_active="1" and year(tanggal)=? and month(tanggal)=?',[$year,$month])
                    ->groupBy(DB::raw('tanggal'))
                    ->orderBy('tanggal','ASC')
                    ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
                    ->select(DB::raw('tanggal as period, sum(total) as pengeluaran , 0 as penjualan'))
                    ->whereraw('flag_active="1" and year(tanggal)=? and month(tanggal)=?',[$year,$month])
                    ->groupBy(DB::raw('tanggal'))
                    ->orderBy('tanggal','ASC')
                    ->get();            
        }
        
        
        //merge 2 collection
        foreach ($penjualan as $sell) {
            foreach ($pengeluaran as $buy) {
                if($sell->period===$buy->period){       
                    $sell->pengeluaran=$buy->pengeluaran;
                }
                else {
                    if(!$penjualan->contains('period',$buy->period)){

                        $penjualan->push($buy);
                    }
                }
            }
        }
        //merge done
        //sort collection by date
        foreach ($penjualan as $sell) {
            $sell->period= strtotime($sell->period);
        }
        $penjualan=$penjualan->sortBy('period');

        foreach ($penjualan as $sell) {
            
            if($month==0)
                $sell->period = date('Y-m',$sell->period);   
            else 
                $sell->period = date('Y-m-j',$sell->period);   
            
            
        }
        //sort done
        return json_encode($penjualan);
    }
    public function getDataPenjualan(){
        $data=DB::table('trn_penjualan')
        ->select(DB::raw("sum(jumlah_ikan) as jumlah_ikan, year(tanggal) year, month(tanggal) month"))
        ->whereraw('flag_active = "1" and tanggal < (SELECT date_sub(last_day(CURRENT_DATE), interval 1 month))')
        ->groupby('year', 'month')
        ->orderby('year','asc')
        ->orderby('month','asc')                
        ->get();
        return ($data);
    }
    public function report(){
        $penjualan=DB::table('trn_penjualan')
        ->join('mst_harga_ikan','trn_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
        ->select('trn_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','trn_penjualan.total','trn_penjualan.tanggal',DB::raw("'penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),', penjualan ke-',trn_penjualan.penjualan_ke,', tahap ke-',trn_penjualan.tahap) as keterangan"))
        ->where('trn_penjualan.flag_active','1')
        ->get();
        $total_penjualan=DB::table('trn_penjualan')
        ->where('flag_active','1')
        ->sum('total');
        $total_pengeluaran=DB::table('trn_pengeluaran')
        ->where('flag_active','1')
        ->sum('total');
        $total_final=$total_penjualan-$total_pengeluaran;
        $pengeluaran=DB::table('trn_pengeluaran')
        ->join('jenis_pengeluaran','trn_pengeluaran.id_jenis_pengeluaran','=','jenis_pengeluaran.id_jenis_pengeluaran')
        ->select('trn_pengeluaran.jumlah','trn_pengeluaran.harga_satuan','trn_pengeluaran.total','trn_pengeluaran.tanggal',DB::raw("'pengeluaran' as tipe, concat('Pengeluaran untuk ',lower(jenis_pengeluaran.jenis_pengeluaran)) as keterangan"))
        ->where('trn_pengeluaran.flag_active','1')
        ->get();
        $merge=$penjualan->merge($pengeluaran)->sortBy('tanggal');
        $data=$merge->all();
        
        return Response::json(array(
            'data'=>$data,
            'total_jual'=>$total_penjualan,
            'total_keluar'=>$total_pengeluaran,
            'saldo'=>$total_final,
        ));;
    }
}
