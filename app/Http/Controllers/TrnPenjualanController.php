<?php

namespace App\Http\Controllers;

use App\Model\Trn_Penjualan;
use App\Model\History_Mst_Tarif;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;

class TrnPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan=DB::table('trn_penjualan')->where('flag_active','=','1')->paginate(5);
        $i=1;
        return view('penjualan',['penjualans'=>$penjualan,'i'=>$i]);
    }
    
    function fetch($date)
    {
        $data=DB::select('SELECT id_ukuran, harga_per_ekor FROM history_mst_tarif where :tanggal1 BETWEEN added_at and updated_at or (updated_at is null and added_at<= :tanggal2)', 
                    ['tanggal1'=>$date,
                    'tanggal2'=>$date
                    ]);
        return json_encode($data);
    }

    function getdata($id_ukuran){
        $data=DB::select('SELECT harga_per_ekor FROM history_mst_tarif where id_ukuran= :ukuran', 
                    ['ukuran'=>$id_ukuran]);
        return json_encode($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today=Carbon::now()->toDateString();
        $harga=DB::select('SELECT id_ukuran, harga_per_ekor FROM history_mst_tarif where :tanggal1 BETWEEN added_at and updated_at or (updated_at is null and Date(added_at)<= :tanggal2)', 
                ['tanggal1'=>$today,
                'tanggal2'=>$today
                ]);
        
        return view('penjualan_create',['today'=>$today,'hargas'=>$harga]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_ukuran=request('harga_per_ekor');
        $hist=History_Mst_Tarif::find($id_ukuran);
        $penjualan = new Trn_Penjualan();
        $penjualan->tahap= request('tahap');
        $penjualan->ukuran=$hist->ukuran;
        $penjualan->penjualan_ke=request('penjualan_ke');
        $penjualan->jumlah_ikan=request('jumlah');
        $penjualan->harga_per_ekor=$hist->harga_per_ekor;
        $penjualan->size_from_cm=$hist->size_from_cm;
        $penjualan->size_to_cm=$hist->size_to_cm;
        $penjualan->total=request('total');
        $penjualan->tanggal=request('tanggal');
        $penjualan->added_at=Carbon::now()->toDateTimeString();
        $penjualan->added_by=Auth::user()->id_user;
        $penjualan->flag_active='1';
        $penjualan->save();
        return redirect('/penjualan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Trn_Penjualan $trn_Penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit($id_penjualan)
    {
        $penjualan=Trn_Penjualan::find($id_penjualan);
        $tanggal=date('Y-m-d',strtotime($penjualan->tanggal));
        Log::info('tanggal',['tanggal'=>$tanggal]);
        //semua tarif by tanggal
        $harga=DB::select('SELECT id_ukuran, harga_per_ekor FROM history_mst_tarif where :tanggal1 BETWEEN added_at and updated_at or (updated_at is null and Date(added_at)<= :tanggal2)', 
                ['tanggal1'=>$tanggal,
                'tanggal2'=>$tanggal
                ]);
        //id harga yang di select default
        // $id_ukuran=
        return view('penjualan_edit',['penjualan'=>$penjualan,'hargas'=>$harga,'tanggal'=>$tanggal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_penjualan)
    {
        $id_ukuran=request('harga_per_ekor');
        $hist=History_Mst_Tarif::find($id_ukuran);
        $penjualan = Trn_Penjualan::find($id_penjualan);
        $penjualan->tahap= request('tahap');
        $penjualan->ukuran=$hist->ukuran;
        $penjualan->penjualan_ke=request('penjualan_ke');
        $penjualan->jumlah_ikan=request('jumlah');
        $penjualan->harga_per_ekor=$hist->harga_per_ekor;
        $penjualan->size_from_cm=$hist->size_from_cm;
        $penjualan->size_to_cm=$hist->size_to_cm;
        $penjualan->total=request('total');
        $penjualan->tanggal=request('tanggal');
        $penjualan->updated_at=Carbon::now()->toDateTimeString();
        $penjualan->updated_by=Auth::user()->id_user;
        $penjualan->save();
        return redirect('/penjualan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_penjualan)
    {
        $penjualan=Trn_Penjualan::find($id_penjualan);
        $penjualan->flag_active='0';
        $penjualan->save();
        return redirect('/penjualan');
    }
}
