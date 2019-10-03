<?php

namespace App\Http\Controllers;

use App\Model\Jenis_Pengeluaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class JenisPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis_pengeluaran=DB::table('jenis_pengeluaran')->where('flag_active','=','1')->paginate(10);
        $i=1;
        return view('jenis_pengeluaran.index',['jenis_pengeluarans'=>$jenis_pengeluaran,'i'=>$i]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('jenis_pengeluaran.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jenis=request('jenis_pengeluaran');
        $jenis_pengeluaran= new Jenis_Pengeluaran();
        $jenis_pengeluaran->jenis_pengeluaran=$jenis;
        $jenis_pengeluaran->added_at=Carbon::now()->toDateTimeString();
        $jenis_pengeluaran->added_by=Auth::user()->id_user;
        $jenis_pengeluaran->flag_active='1';
        $jenis_pengeluaran->save();
        return redirect()->route('jenis_pengeluaran.index')->with(['success'=>'Berhasil menambah '.$jenis.'!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jenis_Pengeluaran  $jenis_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Jenis_Pengeluaran $jenis_Pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jenis_Pengeluaran  $jenis_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id_jenis_pengeluaran)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jenis_Pengeluaran  $jenis_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_jenis_pengeluaran)
    {
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jenis_Pengeluaran  $jenis_Pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jenis_pengeluaran)
    {
    
        $jenis_pengeluaran=Jenis_Pengeluaran::find($id_jenis_pengeluaran);
        $jenis=$jenis_pengeluaran->jenis_pengeluaran;
        $jenis_pengeluaran->flag_active='0';
        $jenis_pengeluaran->save();
        return redirect('jenis_pengeluaran')->with(['error'=>'Berhasil menghapus jenis '.$jenis.'!']);
    }
}
