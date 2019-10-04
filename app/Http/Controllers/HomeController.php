<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Model\Trn_Penjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;
use PDF;
use File;

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
        // dd($penjualan);
        $penjualan=$penjualan->values();
        // dd($penjualan);
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function report(Request $request){        
        $month=request('month');
        $year=request('year');
        if ($month==0) {//tahunan
            $periode=$year.'-1-01';
            $start=Carbon::createFromFormat('Y-n-d', $periode)->format('Y-n-d');
            $end=Carbon::createFromFormat('Y-n-d', $periode)->addYears(1)->subDays(1)->format('Y-n-d');
            $penjualan=DB::table('trn_penjualan')
            ->join('mst_harga_ikan','trn_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
            ->select('trn_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','trn_penjualan.total','trn_penjualan.tanggal',DB::raw("'Penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),' (',mst_harga_ikan.size_from_cm,'cm-',mst_harga_ikan.size_to_cm,'cm)') as keterangan"))
            ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=?',$year)
            ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
            ->join('jenis_pengeluaran','trn_pengeluaran.id_jenis_pengeluaran','=','jenis_pengeluaran.id_jenis_pengeluaran')
            ->select('trn_pengeluaran.jumlah','trn_pengeluaran.harga_satuan','trn_pengeluaran.total','trn_pengeluaran.tanggal',DB::raw("'Pengeluaran' as tipe, concat('Pengeluaran untuk ',lower(jenis_pengeluaran.jenis_pengeluaran)) as keterangan"))
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=?',$year)
            ->get();
            $modal=DB::table('modal')
                ->select(DB::raw("'' as jumlah, '' as harga_satuan"),'nominal as total','tanggal',DB::raw("'Modal' as tipe, 'Modal masuk' as keterangan"))
                ->whereraw('modal.flag_active="1" and modal.tanggal between ? and ?',[$start,$end])
                ->get();
            $total_penjualan=DB::table('trn_penjualan')
            ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=?',$year)
            ->sum('total');
            $total_pengeluaran=DB::table('trn_pengeluaran')
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=?',$year)
            ->sum('total');
            $periode_sum=Carbon::createFromFormat('Y-n-d', $periode)->addYears(1)->subDays(1)->format('Y-n-d');
            $periode=$year;
        } else {//bulanan  
            $periode=$year.'-'.$month.'-01';
            $start=Carbon::createFromFormat('Y-n-d', $periode)->format('Y-n-d');
            $end=Carbon::createFromFormat('Y-n-d', $periode)->addMonths(1)->subDays(1)->format('Y-n-d');
            $penjualan=DB::table('trn_penjualan')
            ->join('mst_harga_ikan','trn_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
            ->select('trn_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','trn_penjualan.total','trn_penjualan.tanggal',DB::raw("'Penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),' (',mst_harga_ikan.size_from_cm,'cm-',mst_harga_ikan.size_to_cm,'cm)') as keterangan"))
            ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=? and month(trn_penjualan.tanggal)=?',[$year,$month])
            ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
            ->join('jenis_pengeluaran','trn_pengeluaran.id_jenis_pengeluaran','=','jenis_pengeluaran.id_jenis_pengeluaran')
            ->select('trn_pengeluaran.jumlah','trn_pengeluaran.harga_satuan','trn_pengeluaran.total','trn_pengeluaran.tanggal',DB::raw("'Pengeluaran' as tipe, concat('Pengeluaran untuk ',lower(jenis_pengeluaran.jenis_pengeluaran)) as keterangan"))
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=? and month(trn_pengeluaran.tanggal)=?',[$year,$month])
            ->get();
            $modal=DB::table('modal')
                ->select(DB::raw("'' as jumlah, '' as harga_satuan"),'nominal as total','tanggal',DB::raw("'Modal' as tipe, 'Modal masuk' as keterangan"))
                ->whereraw('modal.flag_active="1" and modal.tanggal between ? and ?',[$start,$end])
                ->get();
            $total_penjualan=DB::table('trn_penjualan')
            ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=? and month(trn_penjualan.tanggal)=?',[$year,$month])
            ->sum('total');
            $total_pengeluaran=DB::table('trn_pengeluaran')
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=? and month(trn_pengeluaran.tanggal)=?',[$year,$month])
            ->sum('total');
            $periode_sum=Carbon::createFromFormat('Y-n-d', $periode)->addMonths(1)->format('Y-n-d');
            $periode=$year.'-'.$month;
            $periode=Carbon::createFromFormat('Y-n', $periode)->format('F Y');
        }
        
        $sum_modal=DB::table('modal')
        ->whereraw('modal.flag_active="1" and modal.tanggal<=?',[$periode_sum])
        ->sum('nominal');
        $sum_pengeluaran=DB::table('trn_pengeluaran')
        ->whereraw('trn_pengeluaran.flag_active="1" and trn_pengeluaran.tanggal<=?',[$periode_sum])
        ->sum('total');
        $sum_penjualan=DB::table('trn_penjualan')
        ->whereraw('trn_penjualan.flag_active="1" and trn_penjualan.tanggal<=?',[$periode_sum])
        ->sum('total');
        $total_profit=$sum_penjualan-$sum_pengeluaran-$sum_modal;
        $total_final=$total_penjualan-$total_pengeluaran;
        $merge=$penjualan->merge($pengeluaran)->merge($modal)->sortBy('tanggal');
        $data=$merge->all();
        $data=array_values($data);
        $today=Carbon::now();
        $title='laporan-keuangan-'.$today->format('j/m/Y');
    	$pdf = PDF::loadview('layouts.keuangan_pdf',['datas'=>$data,
                                                     'total_jual'=>$total_penjualan,
                                                     'total_keluar'=>$total_pengeluaran,
                                                     'saldo'=>$total_final,
                                                     'profit'=>$total_profit,
                                                     'today'=>$today->format('j F Y H:i'),
                                                     'periode'=>$periode]);
        return $pdf->stream($title.'.pdf');
    }
}
