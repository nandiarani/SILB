<?php

namespace App\Http\Controllers;

use App\Model\Trn_Penjualan;
use App\Model\Mst_Harga_Ikan;
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
        $penjualan=DB::table('trn_penjualan')
                    ->join('mst_harga_ikan','trn_penjualan.id_ukuran','=','mst_harga_ikan.id_ukuran')
                    ->where('trn_penjualan.flag_active','=','1')
                    ->orderby('tanggal','desc')
                    ->paginate(10);
        $i=1;
        return view('penjualan.index',['penjualans'=>$penjualan,'i'=>$i]);
    }
    
    function fetch($date)
    {
        $today=Carbon::now()->toDateString();
        if($date==$today){
            Log::info('masok');
            $data=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where flag_active=?',['1']);
        }
        else{
            Log::info('masok 2');
            $data=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where (? BETWEEN added_at and updated_at) OR (updated_at IS NULL AND added_at<=?)', 
            [$date,$date]);
        }
        return json_encode($data);
    }

    function getdata($id_ukuran){
        $data=DB::select('SELECT harga_per_ekor FROM mst_harga_ikan where id_ukuran= :ukuran', 
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
        $harga=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where flag_active=?',['1']);
        
        return view('penjualan.create',['today'=>$today,'hargas'=>$harga]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan = new Trn_Penjualan();
        $penjualan->tahap= request('tahap');
        $penjualan->penjualan_ke=request('penjualan_ke');
        $penjualan->jumlah_ikan=request('jumlah');
        $penjualan->id_ukuran=request('harga_per_ekor');
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
        $tarif=Mst_Harga_Ikan::find($penjualan->id_ukuran);
        $today=Carbon::now()->toDateString();
        //semua tarif by tanggal
        if($penjualan->tanggal==$today){
            $harga=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where flag_active=?',['1']);
        }
        else{
            $harga=DB::select('SELECT id_ukuran, ukuran, harga_per_ekor, size_from_cm, size_to_cm FROM mst_harga_ikan where (? BETWEEN added_at and updated_at) OR (updated_at IS NULL AND added_at<=?)', 
            [$penjualan->tanggal,$penjualan->tanggal]);
        }
        //id harga yang di select default
        $ukuran=$penjualan->id_ukuran;
        return view('penjualan.edit',['penjualan'=>$penjualan,'hargas'=>$harga,'tanggal'=>$penjualan->tanggal,'ukuran'=>$ukuran,'harga_per_ekor'=>$tarif->harga_per_ekor]);
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
        $penjualan = Trn_Penjualan::find($id_penjualan);
        $penjualan->tahap= request('tahap');
        $penjualan->penjualan_ke=request('penjualan_ke');
        $penjualan->jumlah_ikan=request('jumlah');
        $penjualan->id_ukuran=request('harga_per_ekor');
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
