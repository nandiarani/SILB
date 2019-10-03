<?php

namespace App\Http\Controllers;

use App\Model\Trn_Pengeluaran;
use App\Model\Jenis_Pengeluaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class TrnPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran=DB::table('trn_pengeluaran')
                ->join('jenis_pengeluaran','trn_pengeluaran.id_jenis_pengeluaran','=','jenis_pengeluaran.id_jenis_pengeluaran')
                ->select('trn_pengeluaran.*','jenis_pengeluaran.jenis_pengeluaran')
                ->where('trn_pengeluaran.flag_active','=','1')
                ->orderBy('trn_pengeluaran.tanggal','desc')
                ->paginate(10);
        $i=1;
        return view('pengeluaran.index',['pengeluarans'=>$pengeluaran,'i'=>$i]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisPengeluaran=DB::table('jenis_pengeluaran')->select('id_jenis_pengeluaran','jenis_pengeluaran')->where('flag_active','1')->get();
        $today=Carbon::now()->toDateString();
        return view('pengeluaran.create',['jenis_pengeluaran'=>$jenisPengeluaran,'today'=>$today]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pengeluaran= new Trn_Pengeluaran();
        $pengeluaran->tanggal=request('tanggal');
        $pengeluaran->id_jenis_pengeluaran=request('jenis_pengeluaran');
        $pengeluaran->jumlah=request('jumlah');
        $pengeluaran->harga_satuan=request('harga_satuan');
        $pengeluaran->total=request('total');
        $pengeluaran->added_at=Carbon::now()->toDateTimeString();
        $pengeluaran->added_by=Auth::user()->id_user;
        $pengeluaran->flag_active='1';
        $pengeluaran->save();
        return redirect('/pengeluaran')->with('success','Transaksi pengeluaran berhasil dimasukkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trn_Pengeluaran  $trn_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Trn_Pengeluaran $trn_Pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trn_Pengeluaran  $trn_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pengeluaran)
    {
        $pengeluaran=Trn_Pengeluaran::find($id_pengeluaran);
        $tanggal=date('Y-m-d',strtotime($pengeluaran->tanggal));
        $jenis_pengeluaran=DB::table('jenis_pengeluaran')->select('id_jenis_pengeluaran','jenis_pengeluaran')->where('flag_active','1')->get();
        return view('pengeluaran.edit',compact('pengeluaran','jenis_pengeluaran','tanggal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trn_Pengeluaran  $trn_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pengeluaran)
    {
        $pengeluaran= Trn_Pengeluaran::find($id_pengeluaran);
        $pengeluaran->tanggal=request('tanggal');
        $pengeluaran->id_jenis_pengeluaran=request('jenis_pengeluaran');
        $pengeluaran->jumlah=request('jumlah');
        $pengeluaran->harga_satuan=request('harga_satuan');
        $pengeluaran->total=request('total');
        $pengeluaran->updated_at=Carbon::now()->toDateTimeString();
        $pengeluaran->updated_by=Auth::user()->id_user;
        $pengeluaran->save();
        return redirect('/pengeluaran')->with('info','Transaksi pengeluaran berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trn_Pengeluaran  $trn_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pengeluaran)
    {
        $pengeluaran= Trn_Pengeluaran::find($id_pengeluaran);
        $pengeluaran->flag_active='0';
        $pengeluaran->save();
        return redirect('/pengeluaran')->with('error','Transaksi pengeluaran berhasil dihapus!');
    }
}
