<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Model\Trn_Penjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
        $years=DB::select("select year(tanggal) as year from trn_penjualan union DISTINCT select year(tanggal) as year from trn_pengeluaran order by year");
        return view('home',['years'=>$years]);
    }
    public function fetchMonth($year)
    {
        $month=DB::select("select * from 
                            (
                                (select month(tanggal) as mon, monthname(tanggal) as month from trn_penjualan WHERE flag_active='1' and year(tanggal)=?) 
                                union (select month(tanggal) as mon, monthname(tanggal) as month from trn_pengeluaran WHERE flag_active='1' and year(tanggal)=?)
                            ) a
                            order by a.mon",[$year,$year]);
        return json_encode($month);
    }
    function fetchChart($month,$year){        
               
        if ($month==0) {
            $penjualan=DB::table('trn_penjualan')
                    ->select(DB::raw('concat("1 ",date_format(tanggal,"%M %Y")) as period, sum(total) as penjualan , 0 as pengeluaran'))
                    ->whereraw('flag_active="1" and year(tanggal)=?',$year)
                    ->groupBy(DB::raw('period'))
                    ->orderBy(DB::raw('STR_TO_DATE(period, "%c %M %Y")'))
                    ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
                    ->select(DB::raw('concat("1 ",date_format(tanggal,"%M %Y")) as period, sum(total) as pengeluaran , 0 as penjualan'))
                    ->whereraw('flag_active="1" and year(tanggal)=?',$year)
                    ->groupBy(DB::raw('period'))
                    ->orderBy(DB::raw('STR_TO_DATE(period, "%c %M %Y")'))
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
        if ($penjualan->count() == 0) {
            foreach ($pengeluaran as $buy) {
                    $penjualan->push($buy);
            }
        } else {
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
        $penjualan=$penjualan->values();
        //sort done
        return json_encode($penjualan);
    }

    
    public function getDataPenjualan(){
        // $data=DB::table('trn_penjualan')
        // ->select(DB::raw("sum(jumlah_ikan) as jumlah_ikan, year(tanggal) year, month(tanggal) month"))
        // ->whereraw('flag_active = "1" and tanggal < (SELECT date_sub(last_day(CURRENT_DATE), interval 1 month))')
        // ->groupby('year', 'month')
        // ->orderby('year','asc')
        // ->orderby('month','asc')                
        // ->get();
        $data=DB::table('trn_penjualan')
        ->join('detil_penjualan','trn_penjualan.id_penjualan','=','detil_penjualan.id_penjualan')
        ->select(DB::raw("sum(detil_penjualan.jumlah_ikan) as jumlah_ikan, year(trn_penjualan.tanggal) year, month(trn_penjualan.tanggal) month"))
        ->whereraw('trn_penjualan.flag_active = "1" and detil_penjualan.flag_active = "1" and trn_penjualan.tanggal < (SELECT date_sub(last_day(CURRENT_DATE), interval 1 month))')
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
        //-----------------------tabel keuangan---------------------------------------------------
            $penjualan=DB::table('trn_penjualan')
            ->join('detil_penjualan','trn_penjualan.id_penjualan','=','detil_penjualan.id_penjualan')
            ->join('mst_harga_ikan','detil_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
            ->select('detil_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','detil_penjualan.subtotal as total','trn_penjualan.tanggal',DB::raw("'Penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),' (',mst_harga_ikan.size_from_cm,'cm-',mst_harga_ikan.size_to_cm,'cm)') as keterangan"))
            ->whereraw('trn_penjualan.flag_active="1" and detil_penjualan.flag_active="1"and year(trn_penjualan.tanggal)=?',$year)
            ->get();
            // $penjualan2=DB::table('trn_penjualan')
            // ->join('mst_harga_ikan','trn_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
            // ->select('trn_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','trn_penjualan.total','trn_penjualan.tanggal',DB::raw("'Penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),' (',mst_harga_ikan.size_from_cm,'cm-',mst_harga_ikan.size_to_cm,'cm)') as keterangan"))
            // ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=?',$year)
            // ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
            ->join('jenis_pengeluaran','trn_pengeluaran.id_jenis_pengeluaran','=','jenis_pengeluaran.id_jenis_pengeluaran')
            ->select('trn_pengeluaran.jumlah','trn_pengeluaran.harga_satuan','trn_pengeluaran.total','trn_pengeluaran.tanggal',DB::raw("'Pengeluaran' as tipe, concat('Pengeluaran untuk ',lower(jenis_pengeluaran.jenis_pengeluaran)) as keterangan"))
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=?',$year)
            ->get();
            $total_penjualan=DB::table('trn_penjualan')
            ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=?',$year)
            ->sum('total');
            $total_pengeluaran=DB::table('trn_pengeluaran')
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=?',$year)
            ->sum('total');

        //-----------------------tabel keuangan---------------------------------------------------
            $total_modal=DB::table('modal')
                ->whereraw('modal.flag_active="1" and year(modal.tanggal)=?',$year)
                ->sum('nominal');

            $periode=$year.'-1-01';
            $end=Carbon::createFromFormat('Y-n-d', $periode)->addYears(1)->format('Y-n-d');
            $periode=$year;
        } else {//bulanan  
            //-----------------------tabel keuangan---------------------------------------------------            
            $penjualan=DB::table('trn_penjualan')
            ->join('detil_penjualan','trn_penjualan.id_penjualan','=','detil_penjualan.id_penjualan')
            ->join('mst_harga_ikan','detil_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
            ->select('detil_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','detil_penjualan.subtotal as total','trn_penjualan.tanggal',DB::raw("'Penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),' (',mst_harga_ikan.size_from_cm,'cm-',mst_harga_ikan.size_to_cm,'cm)') as keterangan"))
            ->whereraw('trn_penjualan.flag_active="1" and detil_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=? and month(trn_penjualan.tanggal)=?',[$year,$month])
            ->get();
            // $penjualan2=DB::table('trn_penjualan')
            // ->join('mst_harga_ikan','trn_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
            // ->select('trn_penjualan.jumlah_ikan as jumlah','mst_harga_ikan.harga_per_ekor AS harga_satuan','trn_penjualan.total','trn_penjualan.tanggal',DB::raw("'Penjualan' as tipe, concat('Ukuran ',lower(mst_harga_ikan.ukuran),' (',mst_harga_ikan.size_from_cm,'cm-',mst_harga_ikan.size_to_cm,'cm)') as keterangan"))
            // ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=? and month(trn_penjualan.tanggal)=?',[$year,$month])
            // ->get();
            $pengeluaran=DB::table('trn_pengeluaran')
            ->join('jenis_pengeluaran','trn_pengeluaran.id_jenis_pengeluaran','=','jenis_pengeluaran.id_jenis_pengeluaran')
            ->select('trn_pengeluaran.jumlah','trn_pengeluaran.harga_satuan','trn_pengeluaran.total','trn_pengeluaran.tanggal',DB::raw("'Pengeluaran' as tipe, concat('Pengeluaran untuk ',lower(jenis_pengeluaran.jenis_pengeluaran)) as keterangan"))
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=? and month(trn_pengeluaran.tanggal)=?',[$year,$month])
            ->get();
            $total_penjualan=DB::table('trn_penjualan')
            ->whereraw('trn_penjualan.flag_active="1" and year(trn_penjualan.tanggal)=? and month(trn_penjualan.tanggal)=?',[$year,$month])
            ->sum('total');
            $total_pengeluaran=DB::table('trn_pengeluaran')
            ->whereraw('trn_pengeluaran.flag_active="1" and year(trn_pengeluaran.tanggal)=? and month(trn_pengeluaran.tanggal)=?',[$year,$month])
            ->sum('total');

            //-----------------------tabel profit---------------------------------------------------
            $total_modal=DB::table('modal')
                        ->whereraw('modal.flag_active="1" and year(modal.tanggal)=? and month(modal.tanggal)=?',[$year,$month])
                        ->sum('nominal');

            $periode=$year.'-'.$month.'-01';
            $end=Carbon::createFromFormat('Y-n-d', $periode)->addMonths(1)->format('Y-n-d');
            $periode=$year.'-'.$month;
            $periode=Carbon::createFromFormat('Y-n', $periode)->format('F Y');
        }
        // dd($penjualan,$penjualan2);
        //table profit
            //keseluruhan
                $modal_after=DB::table('modal')
                ->whereraw('modal.flag_active="1" and modal.tanggal<?',[$end])
                ->sum('nominal');
                $pengeluaran_after=DB::table('trn_pengeluaran')
                ->whereraw('trn_pengeluaran.flag_active="1" and trn_pengeluaran.tanggal<?',[$end])
                ->sum('total');
                $penjualan_after=DB::table('trn_penjualan')
                ->whereraw('trn_penjualan.flag_active="1" and trn_penjualan.tanggal<?',[$end])
                ->sum('total');
            //perperiode
                $modal_before=$modal_after-$total_modal;
                $penjualan_before=$penjualan_after-$total_penjualan;
                $pengeluaran_before=$pengeluaran_after-$total_pengeluaran;
            //total
        $total_profit=$penjualan_after-$pengeluaran_after-$modal_after;
        $tabel_profit= ['m_before'=>$modal_before,
                        'm_now'=>$total_modal,
                        'm_after'=>$modal_after,
                        'o_before'=>$pengeluaran_before,
                        'o_now'=>$total_pengeluaran,
                        'o_after'=>$pengeluaran_after,
                        's_before'=>$penjualan_before,
                        's_now'=>$total_penjualan,
                        's_after'=>$penjualan_after,
                        'profit'=>$total_profit];
        $total_final=$total_penjualan-$total_pengeluaran;
        $merge=$penjualan->merge($pengeluaran)->sortBy('tanggal');
        $tabel_keuangan=$merge->all();
        $tabel_keuangan=array_values($tabel_keuangan);
        $today=Carbon::now();
        $title='laporan-keuangan-'.$today->format('j/m/Y');
    	$pdf = PDF::loadview('layouts.keuangan_pdf',['tabel_keuangan'=>$tabel_keuangan,
                                                     'total_jual'=>$total_penjualan,
                                                     'total_keluar'=>$total_pengeluaran,
                                                     'saldo'=>$total_final,
                                                     'tabel_profit'=>$tabel_profit,
                                                     'today'=>$today->format('j F Y H:i'),
                                                     'periode'=>$periode]);
        return $pdf->stream($title.'.pdf');
    }

    public function forecast(){
        
        $url = 'https://lele-sarima.herokuapp.com/forecastdata'; 
        $client = new Client();
        $request = $client->get($url, ['headers' => ['Accept' => 'application/json','Content-type' => 'application/json']]);
        $response=$request->getBody()->getContents();
        return $response;
    }
}
