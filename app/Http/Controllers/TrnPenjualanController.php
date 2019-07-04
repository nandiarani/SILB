<?php

namespace App\Http\Controllers;

use App\Model\Trn_Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

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
            ->join('mst_tarif_by_ukuran');
        
        return view('');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $harga_ikan=DB::table('mst_tarif_by_ukuran')->where('flag_active','=','1')->get();
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Trn_Penjualan $trn_Penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trn_Penjualan $trn_Penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trn_Penjualan  $trn_Penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trn_Penjualan $trn_Penjualan)
    {
        //
    }
}
